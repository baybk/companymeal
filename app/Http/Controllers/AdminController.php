<?php

namespace App\Http\Controllers;

use App\Models\BalanceChangeHistory;
use App\Models\RemarkDatePaided;
use App\Models\User;
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

class AdminController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth');
        $this->middleware('adminAuth');
    }

    public function orders() {
        $users = User::where('name', '!=', 'fakeUser1')->get();
        $lastPaidedList = RemarkDatePaided::orderBy('id', 'desc')->simplePaginate(10);  //get()->take(7)->sortByDesc('id');
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
                            'change_number' => intval(env('MEAL_PRICE', 20000)),
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
            User::first()->notify(new DailyBalanceNotification($this->getDataForReport()));
        } catch (\Throwable $th) {
            Log::info($th->getMessage());
            $this->writeLogBalanceReport();
        }

        $request->session()->flash('status', 'Request thành công');
        return redirect('/home');
    }

    private function writeLogBalanceReport($type = 'REPORT DAILY BALANCE') {
        Log::info($type);
        Log::info($this->getDataForReport());
    }

    private function getDataForReport() {
        $users = User::where('name', '!=', 'fakeUser1')->get();
        $arrayData = [];
        $i = 1;
        foreach ($users as $user) {
            $arrayData[$i . '. ' . $user->name] = number_format($user->balance) . ' VND';
            $i++;
        }

        return $arrayData;
    }

    public function editUserBalance(Request $request, $userId) {
        $user = User::findOrFail($userId);
        $userHistories = BalanceChangeHistory::where('user_id', $userId)->orderBy('id', 'desc')->simplePaginate(10);
        return view('admin.editUserBalance', compact('userHistories', 'user'));
    }

    public function postEditUserBalance(Request $request, $userId) {
        $user = User::findOrFail($userId);
        $adminUser = User::where('role', 'admin')->first();
        if (
            !isset($request->money) || empty($request->money) ||
            !isset($request->reason) || empty($request->reason) ||
            !isset($request->pass) || empty($request->pass)
        ) {
            $request->session()->flash('error', 'Vui lòng điền đủ thông tin');
            return redirect()->back()->withInput();
        }

        if (
            !Hash::check($request->pass, $adminUser->password)
        ) {
            $request->session()->flash('error', 'Pass not right');
            return redirect()->back()->withInput();
        }
        
        $changeMoney = (int) $request->money;
        $oldBalance = $user->balance;

        try {
            DB::beginTransaction();
            
            $user->balance = $user->balance + $changeMoney;
            $user->save();

            BalanceChangeHistory::create([
                'user_id' => $userId,
                'reason' => $request->reason,
                'balance_before_change' => $oldBalance,
                'change_number' => $changeMoney,
            ]);

            DB::commit();
        } catch (\Throwable $th) {
            DB::rollBack();
            $request->session()->flash('error', 'Có lỗi server khi xử lí với cơ sở dữ liệu');
            return redirect()->back()->withInput();
        }

        try {
            User::first()->notify(new ReportWhenChangeBalanceNotification($this->getDataForReport()));
        } catch (\Throwable $th) {
            Log::info($th->getMessage());
            $this->writeLogBalanceReport('REPORT PRIVATE');
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
}
