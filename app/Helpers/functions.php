<?php

use Carbon\Carbon;

if (!function_exists('transChoiceHp')) {
    function transChoiceHp($transCode, $choiceNum = 1)
    {
        return trans_choice($transCode, $choiceNum);
    }
}
