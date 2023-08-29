<?php

namespace App\Http\Controllers;

use App\Http\Contract\UserBusiness;
use App\Models\BalanceChangeHistory;
use App\Models\RemarkDatePaided;
use App\Models\Sprint;
use App\Models\Story;
use App\Models\Task;
use App\Models\User;
use App\Models\ProjectNote;
use App\Notifications\DailyBalanceNotification;
use App\Notifications\RandomDeliverNotification;
use App\Notifications\ReportWhenChangeBalanceNotification;
use Carbon\Carbon;
use Google\Service\CloudSourceRepositories\Repo;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Session;
use Illuminate\Support\Str;

class AdminController extends Controller
{
    use UserBusiness;
    
    public function __construct()
    {
        $this->middleware('auth');
        $this->middleware('adminAuth');
    }

    public function orders() {
        // $users = User::where('name', '!=', FAKE_USER_NAME)->get();
        $users = $this->getUsersListInCurrentTeam();
        $lastPaidedList = RemarkDatePaided::orderBy('id', 'desc')->simplePaginate(10);
        return view('admin.orders', compact('users', 'lastPaidedList'));
    }

    public function postOrders(Request $request) {
        if (!isset($request->userIds) || empty($request->userIds)) {
            $request->session()->flash('error', 'Không ai order');
            return redirect()->back()->withInput();
        }

        $userIds = $request->userIds;
        
        if (!env('APP_DEBUG', true)) {
            try {
                DB::beginTransaction();
                $listUserText = '';
                foreach ($userIds as $userId) {
                    // DB::transaction(function ($userId) {
                        $userId = (int) $userId;
                        $user = User::findOrFail($userId);
                        $oldBalance = $user->balance;
                        $user->balance = $user->balance - intval(env('MEAL_PRICE', 20000));
                        $user->save();

                        BalanceChangeHistory::create([
                            'user_id' => $userId,
                            'reason' => 'Trừ tiền cơm hằng ngày',
                            'balance_before_change' => $oldBalance,
                            'change_number' => -intval(env('MEAL_PRICE', 20000)),
                        ]);
                        $listUserText = $listUserText . $user->name . ' ;';
                    // });
                }

                RemarkDatePaided::create([
                    'date_remark' => Carbon::now(),
                    'order_number' => count($userIds),
                    'user_list_paid' => $listUserText
                ]);
                DB::commit();
            } catch (\Throwable $th) {
                DB::rollBack();
                $request->session()->flash('error', 'Có lỗi server khi xử lí với cơ sở dữ liệu');
                return redirect()->back()->withInput();
            }
        }

        try {
            User::first()->notify(new DailyBalanceNotification($this->getDataForReport(REASON_DAILY_RICE)));
        } catch (\Throwable $th) {
            Log::info($th->getMessage());
            $this->writeLogBalanceReport();
        }

        $request->session()->flash('status', 'Request thành công');
        return redirect('/home');
    }

    private function writeLogBalanceReport($reportReson = REASON_DAILY_RICE) {
        Log::info($reportReson);
        Log::info($this->getDataForReport($reportReson));
    }

    public function getDataForReport($reportReson = REASON_DAILY_RICE) {
        $reportReasonOffical = $reportReson . ' ( ' . date('d-m-Y H:i') . ' )';
        $users = User::where('name', '!=', FAKE_USER_NAME)->get();
        $arrayData = [
            'report_reson' => $reportReasonOffical
        ];
        $i = 1;
        foreach ($users as $user) {
            $arrayData[$i . '. ' . $user->name] = number_format($user->balance) . ' VND';
            $i++;
        }

        return $arrayData;
    }

    public function editUserBalance(Request $request, $userId) {
        $user = User::findOrFail($userId);
        // $userHistories = $user->getBalanceChangeHistoriesInCurrentTeam();
        $currentTasks =  Task::where(
            'team_id', $this->getCurrentTeam()->id
        )
        ->where(
            'sprint_id', $this->getCurrentSprint() ? $this->getCurrentSprint()->id : 0
        )
        ->where(
            'user_id', $userId
        )
        ->orderBy('from_date', 'asc')->get();
        return view('admin.editUserBalance', compact('currentTasks', 'user'));
    }

    public function postEditUserBalance(Request $request, $userId) {
        $user = User::where(
            'id', $userId
        )->first();
        $adminUser = auth()->user();
        if (
            !$user || !$request->hours_per_week
        ) {
            $request->session()->flash('error', 'Vui lòng điền đủ thông tin');
            return redirect()->back()->withInput();
        }
        try {
            DB::beginTransaction();
            
            $user->hours_per_week = $request->hours_per_week;
            if (!empty($request->email)) {
                $user->email = $request->email;
            }
            $user->save();

            DB::commit();
        } catch (\Throwable $th) {
            Log::info($th->getMessage());
            DB::rollBack();
            $request->session()->flash('error', 'Có lỗi server khi xử lí với cơ sở dữ liệu');
            return redirect()->back()->withInput();
        }
        return redirect('/home');
    }

    public function randomDeliver(Request $request) {
        $usersCount = User::all()->count();
        $userId = random_int(1, $usersCount -1);

        try {
            User::first()->notify(new RandomDeliverNotification($userId));
        } catch (\Throwable $th) {
            Log::info($th->getMessage());
        }

        $request->session()->flash('selectedUserId', $userId);
        return redirect()->back();
    }

    public function orders2() {
        $users = $this->getUsersListInCurrentTeam();
        $lastPaidedList = RemarkDatePaided::where('team_id', $this->getCurrentTeam()->id)
                                            ->orderBy('id', 'desc')
                                            ->simplePaginate(10);
        return view('admin.orders2', compact('users', 'lastPaidedList'));
    }

    public function postOrders2(Request $request) {
        if (!isset($request->userIds) || empty($request->userIds)) {
            $request->session()->flash('error', 'Lỗi: Chưa ai được chọn!!');
            return redirect()->back()->withInput();
        }
        $userIds = $request->userIds;
        $arrMoney = $request->list_money;
        if (
            in_array(null, $arrMoney) ||
            !isset($request->reason_type) || empty($request->reason_type) ||
            !isset($request->submit_type) || empty($request->submit_type) ||
            ($request->reason_type != REASON_TYPE_DAILY_RICE && $request->reason_type != REASON_TYPE_OTHER)
        ) {
            $request->session()->flash('error', 'Lỗi: Thiếu thông tin số tiền hoặc lí do yêu cầu');
            return redirect()->back()->withInput();
        }

        $reason = REASON_DAILY_RICE;
        if ($request->reason_type != REASON_TYPE_DAILY_RICE) {
            $reason = isset($request->reason) ? $request->reason : 'Lí do khác';
        }
        $filteredArr = array_intersect_key($arrMoney, array_flip($userIds));

        $submitType = intval($request->submit_type);
        if (
            ($submitType == 1 || $submitType == 2) &&
            !env('APP_DEBUG', true)
        ) {
            try {
                DB::beginTransaction();
                $listUserText = '';
                foreach ($filteredArr as $userId => $money) {
                    // DB::transaction(function ($userId) {
                        $userId = (int) $userId;
                        $user = User::findOrFail($userId);
                        $oldBalance = $user->getBalanceInCurrentTeam();
                        $user->changeBalanceInCurrentTeam(-intval($money));
                        $user->save();

                        BalanceChangeHistory::create([
                            'user_id' => $userId,
                            'team_id' => $this->getCurrentTeam()->id,
                            'reason' => $reason,
                            'balance_before_change' => $oldBalance,
                            'change_number' => -intval($money),
                        ]);
                        $listUserText = $listUserText . $user->name . '; ';
                    // });
                }

                if ($request->reason_type == REASON_TYPE_DAILY_RICE) {
                    RemarkDatePaided::create([
                        'team_id' => $this->getCurrentTeam()->id,
                        'date_remark' => Carbon::now(),
                        'order_number' => count($userIds),
                        'user_list_paid' => $listUserText,
                        'reason' => $reason
                    ]);
                }
                DB::commit();
                $request->session()->flash(
                    'status',
                    'Thực hiện *' . $reason . '* thành công - ngày ' . date('d-m-Y')
                );
                try {
                    User::first()->notify(new DailyBalanceNotification($this->getDataForReport(REASON_DAILY_RICE)));
                } catch (\Throwable $th) {
                    Log::info($th->getMessage());
                    $this->writeLogBalanceReport();
                }
            } catch (\Throwable $th) {
                Log::info($th->getMessage());
                DB::rollBack();
                $request->session()->flash('error', 'Có lỗi server khi xử lí với cơ sở dữ liệu');
                return redirect()->back()->withInput();
            }
        }

        if ($submitType == 1 || $submitType == 3) {
            // random deliver name in selected list users
            $randomeUserId = $userIds[array_rand($userIds)];
            $randomUser = User::find($randomeUserId);
            try {
                User::first()->notify(new RandomDeliverNotification($randomUser->name));
            } catch (\Throwable $th) {
                Log::info($th->getMessage());
            }
            $request->session()->flash('random_user_id', $randomUser->name);
            $oldRandomDeliverCounter = $request->session()->get('random_deliver_counter', 0);
            $request->session()->put('random_deliver_counter', $oldRandomDeliverCounter + 1);
            $request->session()->flash('selected_user_ids', $userIds);
        }
        return redirect('/home');
    }

    public function deleteUser($id)
    {
        $user = User::findOrFail($id);
        if ($user) {
            $user->delete();
        }
        return redirect('/home');
    }

    public function createSprint(Request $request)
    {
        return view('auth.createSprint');
    }

    public function postCreateSprint(Request $request)
    {
        $requestData = $request->all();
        $requestData['team_id'] = $this->getCurrentTeam()->id;
        $sprint = Sprint::create($requestData);
        return redirect('/home');
    }

    public function createTask(Request $request)
    {
        $users = $this->getUsersListInCurrentTeam();
        $stories = Story::where(
            'team_id', $this->getCurrentTeam()->id
        )->get();
        $latestSprint = Sprint::where(
            'team_id', $this->getCurrentTeam()->id
        )->orderBy('id', 'desc')->first();
        $currentSprint = $this->getCurrentSprint();
        return view('auth.createTask', compact('users', 'stories', 'latestSprint', 'currentSprint'));
    }

    public function postCreateTask(Request $request)
    {
        $requestData = $request->all();
        $requestData['team_id'] = $this->getCurrentTeam()->id;
        $namePrefix = '';
        if ($request->story) {
            $namePrefix = "[" . $request->story . "]";
            if ($request->task_type) {
                $namePrefix = $namePrefix . "[" . $request->task_type . "]";
            }
        }

        if ($request->stt) {
            $namePrefix = '['.strval($request->stt).']' . $namePrefix;
        }

        $requestData['name'] = $namePrefix . " " . $requestData['name'];
        $currentSprint = Sprint::where(
            'team_id', $this->getCurrentTeam()->id
        )->orderBy('id', 'desc')->first();
        $requestData['sprint_id'] = $currentSprint->id;
        $sprint = Task::create($requestData);

        $request->session()->flash('flash_message', 'Tạo Task thành công.');
        return redirect()->route('admin.createTask');
    }

    public function listSprint(Request $request)
    {
        $requestData = $request->all();
        $requestData['team_id'] = $this->getCurrentTeam()->id;
        $sprints = Sprint::where(
            'team_id', $this->getCurrentTeam()->id
        )->orderBy('id', 'desc')->get();

        $currentSprint = $this->getCurrentSprint() ? $this->getCurrentSprint()->id : 0;

        return view('trello.list-sprint', compact('sprints', 'currentSprint'));
    }

    public function editSprint(Request $request, $sprintId)
    {
        $sprint = Sprint::findOrFail($sprintId);
        return view('trello.edit-sprint', compact('sprint'));
    }

    public function postEditSprint(Request $request, $sprintId)
    {
        $requestData = $request->all();
        $sprint  = Sprint::findOrFail($sprintId);
        unset($requestData['_token']);
        Sprint::where('id',$sprintId)->update($requestData);
        return redirect()->route('admin.listSprint');
    }

    public function editTask(Request $request, $taskId)
    {
        $task = Task::findOrFail($taskId);
        $users = $this->getUsersListInCurrentTeam();
        $stories = Story::where(
            'team_id', $this->getCurrentTeam()->id
        )->get();
        return view('trello.edit-task', compact('task', 'stories', 'users'));
    }

    public function postEditTask(Request $request, $taskId)
    {
        $requestData = $request->all();
        $task  = Task::findOrFail($taskId);
        unset($requestData['_token']);
        unset($requestData['story']);
        unset($requestData['task_type']);
        unset($requestData['stt']);
        Task::where('id',$taskId)->update($requestData);
        return redirect()->route('admin.todayTask');
    }

    public function deleteTask(Request $request, $taskId)
    {
        $task  = Task::findOrFail($taskId);
        $task->delete();
        return redirect()->route('admin.todayTask');
    }

    public function moveDoingTask(Request $request, $taskId)
    {
        $task  = Task::findOrFail($taskId);
        $task->progress = 10;
        $task->save();
        return redirect()->route('admin.todayTask');
    }

    public function checkDoneTask(Request $request, $taskId)
    {
        $task  = Task::findOrFail($taskId);
        $task->progress = 100;
        $task->save();
        return redirect()->route('admin.todayTask');
    }

    public function moveTaskToLastestSprint(Request $request, $taskId)
    {
        $task  = Task::findOrFail($taskId);
        # find lastest sprint id
        $lastestSprint = Sprint::where(
            'team_id', $this->getCurrentTeam()->id
        )
        ->orderBy('id', 'desc')
        ->first();
        if (!$lastestSprint) return redirect('/');
        
        if ($task->sprint_id != $lastestSprint->id) {
            $task->sprint_id = $lastestSprint->id;
            $task->save();
        }
        return redirect()->route('admin.todayTask');
    }

    public function setDefaultSprint(Request $request, $sprintId)
    {
        $requestData = $request->all();
        $requestData['team_id'] = $this->getCurrentTeam()->id;
        $sprint = Sprint::where(
            'team_id', $this->getCurrentTeam()->id
        )
        ->where('id', $sprintId)
        ->first();
        if (!$sprint) return redirect('/');
        session()->put('current_sprint_id', (int)$sprintId);

        return redirect()->route('admin.listSprint');
    }

    public function listStory(Request $request)
    {
        $requestData = $request->all();
        $stories = Story::where(
            'team_id', $this->getCurrentTeam()->id
        )->orderBy('id', 'desc')->get();
        return view('trello.listStory', compact('stories'));
    }

    public function createStory(Request $request)
    {
        return view('trello.createStory');
    }

    public function deleteStory(Request $request, $storyId)
    {
        $story = Story::findOrFail($storyId);
        $story->delete();
        return redirect()->route('admin.listStory');
    }

    public function postCreateStory(Request $request)
    {
        $requestData = $request->all();
        $requestData['team_id'] = $this->getCurrentTeam()->id;
        $requestData['name'] = Str::slug($requestData['desc']);
        $stories = Story::create(
            $requestData
        );
        return redirect()->route('admin.listStory');
    }

    public function todayTask(Request $request)
    {
        // Log::info('team_id session=');
        // Log::info(session('team_id'));
        // Log::info('ss lifetime=');
        // Log::info(env('SESSION_LIFETIME'));

        $requestData = $request->all();
        $requestData['team_id'] = $this->getCurrentTeam()->id;
        $data = [];
        $listUsers = $this->getUsersListInCurrentTeam();
        $isTodayTask = false;
        foreach($listUsers as $user) {
            $data_one_user = [
                "user" => $user->toArray(),
                "tasks" => [
                ]
            ];
            $now = Carbon::now()->toDateString();
            $tasksOneUser =  Task::where('team_id', $this->getCurrentTeam()->id)
                                    ->where('sprint_id', $this->getCurrentSprint() ? $this->getCurrentSprint()->id : 0)
                                    ->where('user_id', $user->id)
                                    // ->orderBy('from_date', 'asc')
                                    ->orderBy('name', 'asc')
                                    ->get();
            if (isset($requestData['is_today_task'])) {
                $isTodayTask = true;
                $tasksOneUser =  Task::where('team_id', $this->getCurrentTeam()->id)
                                    ->where('sprint_id', $this->getCurrentSprint() ? $this->getCurrentSprint()->id : 0)
                                    ->whereDate('from_date', '<=', $now)
                                    ->whereDate('end_date', '>=', $now)
                                    ->where('user_id', $user->id)
                                    // ->orderBy('from_date', 'asc')
                                    ->orderBy('name', 'asc')
                                    ->get();
            }
            $data_one_user['tasks'] = $tasksOneUser;
            $data[] = $data_one_user;
        }

        return view('trello.today-tasks', compact('data', 'isTodayTask'));
    }

    public function listNote(Request $request)
    {
        $requestData = $request->all();
        $notes = ProjectNote::where(
            'team_id', $this->getCurrentTeam()->id
        )->orderBy('id', 'desc')->get();
        return view('trello.listNote', compact('notes'));
    }

    public function createNote(Request $request)
    {
        return view('trello.createNote');
    }

    public function postCreateNote(Request $request)
    {
        $requestData = $request->all();
        $requestData['team_id'] = $this->getCurrentTeam()->id;
        $note = ProjectNote::create(
            $requestData
        );
        return redirect()->route('admin.listNote');
    }

    public function deleteNote(Request $request, $noteId)
    {
        $note = ProjectNote::findOrFail($noteId);
        $note->delete();
        return redirect()->route('admin.listNote');
    }
}
