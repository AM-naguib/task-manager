<?php

namespace Database\Seeders;

use App\Models\User;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;

class UserSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $user = User::create([
            'name' => 'halim',
            'email' => 'halim@gmail.com',
            'username' => 'halim',
            'password' => Hash::make('password')
        ]);
        $user = User::create([
            'name' => 'youssef',
            'email' => 'youssef@gmail.com',
            'username' => 'youssef',
            'password' => Hash::make('password')
        ]);
    }
}
