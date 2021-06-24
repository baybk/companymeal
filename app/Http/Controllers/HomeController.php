<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;

class HomeController extends Controller
{
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
    public function index()
    {
        $users = User::where('name', '!=', 'fakeUser1')->get();
        $totalBalance = 0;
        foreach ($users as $user) {
            $totalBalance = $totalBalance + $user->balance;
        }
        return view('home', compact('users', 'totalBalance'));
    }
}
