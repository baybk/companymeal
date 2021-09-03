<?php

namespace App\Http\Controllers;

use App\Http\Contract\UserBusiness;
use App\Models\Team;
use App\Models\User;
use Illuminate\Http\Request;

use App\Models\UsersTeam;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Validator;
use Illuminate\Auth\Events\Registered;
use Illuminate\Http\JsonResponse;
use Illuminate\Support\Facades\DB;

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
        $this->middleware('adminAuth');
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

    // THIS BELOW PART FOR CREATE TEAM
    protected function validatorAdminAndTeam(array $data)
    {
        return Validator::make($data, [
            'team_name' => ['required', 'string', 'max:255'],
            'name' => ['required', 'string', 'max:255'],
            'email' => ['required', 'string', 'email', 'max:255', 'unique:users'],
            'password' => ['required', 'string', 'min:8', 'confirmed'],
        ]);
    }

    protected function createAdminAndTeam(array $data)
    {
        $user = User::create([
            'name' => $data['name'],
            'email' => $data['email'],
            'password' => Hash::make($data['password']),
        ]);
        $team = Team::create([
            'name' => $data['team_name']
        ]);
        UsersTeam::create([
            'user_id' => $user->id,
            'team_id' => $team->id,
            'role' => USER_ROLE_ADMIN
        ]);
        $user->team_id = $team->id;
        return $user;
    }

    public function registerAdminAndTeam()
    {
        return view('register_team');
    }

    public function postRegisterAdminAndTeam(Request $request)
    {
        $this->validatorAdminAndTeam($request->all())->validate();
        event(new Registered($user = $this->createAdminAndTeam($request->all())));
        session()->flash(
            'success_message', 
            __('messages.register_team_success_please_login_to_manage_your_team', ['team_id' => $user->team_id]));
        return redirect('/login');
    }
}
