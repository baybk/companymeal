<?php

namespace App\Policies;

use App\Models\User;
use Illuminate\Auth\Access\HandlesAuthorization;
use Illuminate\Support\Facades\Log;

class UserManagementPolicy
{
    use HandlesAuthorization;

    /**
     * Create a new policy instance.
     *
     * @return void
     */
    public function __construct()
    {
        //
    }

    public function viewListUser() {
        return true;
    }

    public function viewUser(User $user, $userId) {
        // Log::debug($userId);
        // if ((int) $userId % 2 == 0) {
        //     return true;
        // }
        // return false;

        return $user->id == $userId;
    }
}
