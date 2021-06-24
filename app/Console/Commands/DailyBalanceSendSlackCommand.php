<?php

namespace App\Console\Commands;

use App\Http\Controllers\AdminController;
use App\Models\User;
use App\Notifications\DailyBalanceNotification;
use App\Notifications\ReportWhenChangeBalanceNotification;
use Illuminate\Console\Command;

class DailyBalanceSendSlackCommand extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'slack:balance-report';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Report balance of every one to slack channel';

    /**
     * Create a new command instance.
     *
     * @return void
     */
    public function __construct()
    {
        parent::__construct();
    }

    /**
     * Execute the console command.
     *
     * @return int
     */
    public function handle()
    {
        $arrayData = (new AdminController())->getDataForReport();
        User::first()->notify(new ReportWhenChangeBalanceNotification($arrayData));
    }
}
