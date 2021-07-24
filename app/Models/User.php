<?php

namespace App\Models;

use App\Http\Contract\UserBusiness;
use App\Notifications\ReportWhenChangeBalanceNotification;
use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Laravel\Passport\HasApiTokens;

class User extends Authenticatable
{
    use HasFactory;
    use Notifiable;
    use HasApiTokens;
    use UserBusiness;

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'name',
        'email',
        'password',
        'role',
        'balance'
    ];

    /**
     * The attributes that should be hidden for arrays.
     *
     * @var array
     */
    protected $hidden = [
        'password',
        'remember_token',
    ];

    /**
     * The attributes that should be cast to native types.
     *
     * @var array
     */
    protected $casts = [
        'email_verified_at' => 'datetime',
    ];

    public function routeNotificationForSlack($notification)
    {
        if ($notification instanceof ReportWhenChangeBalanceNotification) {
            return env('PERSONAL_SLACK_CHANNEL_URL', 'https://hooks.slack.com/services/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');
        }
        return env('RICE_SLACK_CHANNEL_URL', 'https://hooks.slack.com/services/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');
    }

    public function routeNotificationForTelegram()
    {
        return '1717746490';
    }

    public function getRoleInTeam($teamId)
    {
        $usersTeam = UsersTeam::where('user_id', $this->id)->where('team_id', $teamId)->first();
        if ($usersTeam) {
            return $usersTeam->role;
        }
        return USER_ROLE_VISITOR;
    }

    public function getBalanceInCurrentTeam()
    {
        $userTeam = UsersTeam::where('user_id', $this->id)
                    ->where('team_id', $this->getCurrentTeam()->id)
                    ->first();
        return $userTeam->balance;
    }

    public function getBalanceChangeHistoriesInCurrentTeam()
    {
        $userHistories = BalanceChangeHistory::where('user_id', $this->id)
                                ->where('team_id', $this->getCurrentTeam()->id)
                                ->orderBy('id', 'desc')
                                ->simplePaginate(10);
        return $userHistories;
    }

    public function getCurrentUserTeam()
    {
        $userTeam = UsersTeam::where('user_id', $this->id)
                        ->where('team_id', $this->getCurrentTeam()->id)
                        ->first();
        return $userTeam;
    }

    public function changeBalanceInCurrentTeam($changeMoney)
    {
        $userTeam = $this->getCurrentUserTeam();
        $userTeam->balance = $userTeam->balance + $changeMoney;
        $userTeam->save();
        return $userTeam;
    }
}
