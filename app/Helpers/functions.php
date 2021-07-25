<?php

use App\Http\Contract\UserBusinessClass;
use Carbon\Carbon;
use Illuminate\Support\Facades\Crypt;
use Illuminate\Support\Str;
use Illuminate\Support\Facades\Auth;

if (!function_exists('transChoiceHp')) {
    function transChoiceHp($transCode, $choiceNum = 1)
    {
        return trans_choice($transCode, $choiceNum);
    }
}

if (!function_exists('generateNewCode')) {
    function generateNewCode()
    {
        $salt = Str::random(20);
        $timestamp = Carbon::now()->timestamp;
        $code = $salt . '_' . $timestamp;
        return $code;
    }
}

if (!function_exists('isAdminUserHelper')) {
    function isAdminUserHelper()
    {
        return (new UserBusinessClass())->isAdminUserHelper();
    }
}

if (!function_exists('getCurrentTeamHelper')) {
    function getCurrentTeamHelper()
    {
        return (new UserBusinessClass())->getCurrentTeam();
    }
}
