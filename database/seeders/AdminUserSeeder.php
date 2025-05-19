<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\User;
use Illuminate\Support\Facades\Hash;

class AdminUserSeeder extends Seeder
{
    public function run()
    {
        User::create([
            'name' => 'Firman Admin',
            'email' => 'admin@firman.com',
            'username' => 'adminFirman',
            'password' => Hash::make('Plplokok12'),
            'role' => 'admin',
            'email_verified_at' => now(),
        ]);
    }
}
