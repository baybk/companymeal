<?php

namespace Database\Seeders;

use App\Models\User;
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
        User::factory()->create([
            'name' => 'Nguyen Van Bay',
            'email' => 'baynguyen1997@gmail.com',
            'role' => 'admin',
            'password' => bcrypt('Pw@01628164331'),
        ]);

        // new Users
        User::factory()->create([
            'name' => 'fakeUser1',
            'email' => 'fakeuser1@gmail.com'
        ]);
    }
}
