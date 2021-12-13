<?php

namespace App\Http\Contract;

use App\Models\Sprint;
use App\Models\Team;
use App\Models\User;
use App\Models\UsersTeam;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Str;

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
        if ($user->getRoleInTeam($this->getCurrentTeam()->id) == USER_ROLE_ADMIN) {
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

    public function getCurrentSprint()
    {
        $currentSprint = Sprint::where(
            'team_id', $this->getCurrentTeam()->id
        )->orderBy('id', 'desc')->first();
        return $currentSprint;
    }

    public function randVerifyLoginCode()
    {
        $rand3Char = Str::random(4);
        $rand3Char = Str::lower($rand3Char);
        $randNum = random_int(1000, 9999);
        $code = $rand3Char . $randNum;
        return $code;
    }
}