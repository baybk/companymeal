<?php

namespace App\Http\Contract;

use App\Models\User;
use App\Models\UsersTeam;
use Illuminate\Support\Facades\Auth;

class UserBusinessClass
{
    use UserBusiness;

    public function isAdminUserHelper()
    {
        return $this->isAdminUser();
    }
}