<?php

namespace App\Http\Contract;

use App\Models\Team;
use App\Models\User;
use App\Models\UsersTeam;
use Illuminate\Support\Facades\Auth;

trait UserBusiness
{
    public function getUsersByTeam($teamId)
    {
        $userIds = UsersTeam::where('team_id', $teamId)->pluck('user_id');
        $users = User::whereIn('id', $userIds)->where('name', 'not like', '%' . FAKE_USER_NAME . '%')->get();
        return $users;
    }

    public function getUsersListInCurrentTeam()
    {
        $teamId = $this->getCurrentTeam()->id;
        $userIds = UsersTeam::where('team_id', $teamId)->pluck('user_id');
        $users = User::whereIn('id', $userIds)->where('name', 'not like', '%' . FAKE_USER_NAME . '%')->get();
        return $users;
    }

    public function isAdminUser()
    {
        if (!session('team_id') || !Auth::check()) {
            return false;
        }
        $user = Auth::user();
        if ($user->getRoleInTeam(session('team_id')) == USER_ROLE_ADMIN) {
            return true;
        }
        return false;
    }

    public function getCurrentTeam()
    {
        if (!session('team_id')) {
            return null;
        }
        return Team::findOrFail(session('team_id'));
    }
}