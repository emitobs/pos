<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\User;

class UserSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        User::create([
            'name' => 'test',
            'phone' => '11111111',
            'email' => 'test@erizos.dev',
            'profile' => 'ADMIN',
            'status' => 'ACTIVE',
            'password' => bcrypt('Test!123'),
        ]);
        User::create([
            'name' => 'test',
            'phone' => '11111111',
            'email' => 'test2@erizos.dev',
            'profile' => 'EMPLOYEE',
            'status' => 'ACTIVE',
            'password' => bcrypt('Test!123'),
        ]);
    }
}
