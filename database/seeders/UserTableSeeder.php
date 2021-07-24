<?php

namespace Database\Seeders;

use App\Models\Team;
use App\Models\User;
use App\Models\UsersTeam;
use Illuminate\Database\Seeder;

class UserTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        // new Admin
        $admin = User::factory()->create([
            'name' => 'Nguyen Van Bay',
            'email' => 'baynguyen1997@gmail.com',
            'password' => bcrypt('123456'),
        ]);

        // new Users
        $user = User::factory()->create([
            'name' => 'fakeUser11',
            // 'name' => FAKE_USER_NAME,
            'email' => 'fakeuser11@gmail.com'
        ]);
        $user2 = User::factory()->create([
            'name' => 'fakeUser22',
            // 'name' => FAKE_USER_NAME,
            'email' => 'fakeuser22@gmail.com'
        ]);

        // New team
        $team = Team::create([
            'name' => 'Rice office 140'
        ]);
        $team2 = Team::create([
            'name' => 'Rice office 35'
        ]);

        // add member to team
        UsersTeam::factory()->create([
            'user_id' => $admin->id,
            'team_id' => $team->id,
            'role' => USER_ROLE_ADMIN
        ]);
        UsersTeam::factory()->create([
            'user_id' => $admin->id,
            'team_id' => $team2->id,
            'role' => USER_ROLE_ADMIN
        ]);

        UsersTeam::factory()->create([
            'user_id' => $user->id,
            'team_id' => $team->id,
            'role' => 'user'
        ]);
        UsersTeam::factory()->create([
            'user_id' => $user2->id,
            'team_id' => $team2->id,
            'role' => 'user'
        ]);
    }
}
