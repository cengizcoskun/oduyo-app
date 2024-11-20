<?php

namespace Database\Seeders;

use App\Enums\UserStatus;
use App\Models\User;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;

class UserSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        User::updateOrCreate(['email' => 'y.cengiz.coskun@gmail.com'], [
            'name' => 'Yasin Cengiz Coskun',
            'email' => 'y.cengiz.coskun@gmail.com',
            'password' => Hash::make('yIck5bKzhtX1b1Lp'),
        ]);
    }
}
