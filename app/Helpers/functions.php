<?php

use Carbon\Carbon;
use Illuminate\Support\Facades\Crypt;
use Illuminate\Support\Str;

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