<?php

namespace App\Http\Controllers;

use App\Http\Contract\UserBusiness;
use App\Models\User;
use Illuminate\Http\Request;

class HomeController extends Controller
{
    use UserBusiness;

    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->middleware('auth');
    }

    /**
     * Show the application dashboard.
     *
     * @return \Illuminate\Contracts\Support\Renderable
     */
    public function index(Request $request)
    {
        $users = $this->getUsersListInCurrentTeam();
        // $users = User::where('name', '!=', FAKE_USER_NAME)->get();
        $totalBalance = 0;
        $selectedUserIdsForRandom = $request->session()->get('selected_user_ids', []);

        foreach ($users as $user) {
            $totalBalance = $totalBalance + $user->getBalanceInCurrentTeam();
        }
        return view('home', compact('users', 'totalBalance', 'selectedUserIdsForRandom'));
    }
}
