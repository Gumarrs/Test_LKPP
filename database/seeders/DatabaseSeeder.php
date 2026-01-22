<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\User;
use Illuminate\Support\Facades\Hash;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     *
     * @return void
     */
    public function run()
    {
        // 1. Akun Admin
        User::create([
            'name' => 'Administrator',
            'email' => 'admin@lkpp.go.id',
            'password' => Hash::make('password'), // Password: password
            'role' => 'admin',
        ]);

        // 2. Akun Sekretariat
        User::create([
            'name' => 'Staf Sekretariat',
            'email' => 'sekretariat@lkpp.go.id',
            'password' => Hash::make('password'),
            'role' => 'sekretariat',
        ]);

        // 3. Akun Asesor
        User::create([
            'name' => 'Tim Asesor',
            'email' => 'asesor@lkpp.go.id',
            'password' => Hash::make('password'),
            'role' => 'asesor',
        ]);
    }
}