<?php

namespace App\Http\Contract;

use App\Models\User;
use App\Models\UsersTeam;

trait UserBusiness
{
    public function getUsersByTeam($teamId)
    {
        $userIds = UsersTeam::where('team_id', $teamId)->pluck('user_id');
        $users = User::whereIn('id', $userIds)->get();
        return $users;
    }
}