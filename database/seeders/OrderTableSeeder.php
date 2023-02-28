<?php

namespace Database\Seeders;

use App\Models\Order;
use App\Models\User;
use Illuminate\Database\Seeder;

class OrderTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $super = User::firstWhere('email', 'super@inosoft.com');
        Order::factory(10)->create([
            'user_id' => $super->id,
        ]);
        Order::factory(10)->create();
    }
}
