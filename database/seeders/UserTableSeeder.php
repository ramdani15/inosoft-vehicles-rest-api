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
        $password = 'password123';

        User::factory()->create([
            'username' => 'super',
            'name' => 'Super Admin',
            'email' => 'super@inosoft.com',
            'password' => bcrypt($password),
        ]);

        User::factory(5)->create([
            'password' => bcrypt($password),
        ]);
    }
}
