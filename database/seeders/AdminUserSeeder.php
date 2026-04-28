<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;
use App\Models\User;

class AdminUserSeeder extends Seeder
{

public function run()
{
    User::updateOrCreate(
        ['email' => 'admin@example.com'],
        [
            'name' => 'Super Admin',
            'role' => 'admin',
            'password' => Hash::make('Admin123!'),
        ]
    );
}
}
