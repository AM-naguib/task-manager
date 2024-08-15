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
        User::create([
            'name' => 'halim',
            'email' => 'halim@gmail.com',
            'username' => 'halim',
            'password' => Hash::make('password')
        ]);
        User::create([
            'name' => 'youssef',
            'email' => 'youssef@gmail.com',
            'username' => 'youssef',
            'password' => Hash::make('password')
        ]);
        User::create([
            'name' => 'saiedoz',
            'email' => 'saiedoz@gmail.com',
            'username' => 'saiedoz',
            'password' => Hash::make('password2')
        ]);
        User::create([
            'name' => 'hoss',
            'email' => 'hoss@gmail.com',
            'username' => 'hoss',
            'password' => Hash::make('password2')
        ]);
        User::create([
            'name' => 'ashraf',
            'email' => 'ashraf@gmail.com',
            'username' => 'ashraf',
            'password' => Hash::make('password')
        ]);
    }
}
