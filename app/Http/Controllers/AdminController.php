<?php

namespace App\Http\Controllers;

use App\Models\BalanceChangeHistory;
use App\Models\RemarkDatePaided;
use App\Models\User;
use App\Notifications\DailyBalanceNotification;
use Carbon\Carbon;
use Google\Service\CloudSourceRepositories\Repo;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;
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
        $lastPaidedList = RemarkDatePaided::all()->sortByDesc('id')->take(10);  //get()->take(7)->sortByDesc('id');
        return view('admin.orders', compact('users', 'lastPaidedList'));
    }

    public function postOrders(Request $request) {
        if (!isset($request->userIds) || empty($request->userIds)) {
            $request->session()->flash('error', 'Không ai order');
            return redirect()->back()->withInput();
        }

        $userIds = $request->userIds;
        
        try {
            DB::beginTransaction();
            $listUserText = '';
            foreach ($userIds as $userId) {
                // DB::transaction(function ($userId) {
                    $userId = (int) $userId;
                    $user = User::findOrFail($userId);
                    $oldBalance = $user->balance;
                    $user->balance = $user->balance - 20000;
                    $user->save();

                    BalanceChangeHistory::create([
                        'user_id' => $userId,
                        'reason' => 'Trừ tiền cơm hằng ngày',
                        'balance_before_change' => $oldBalance,
                        'change_number' => 20000,
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

        User::first()->notify(new DailyBalanceNotification);

        $request->session()->flash('status', 'Request thành công');
        return redirect('/home');
    }

    public function editUserBalance(Request $request, $userId) {
        $user = User::findOrFail($userId);
        $userHistories = BalanceChangeHistory::where('user_id', $userId)->get()->sortByDesc('id');
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

        return redirect('/home');
    }

}
