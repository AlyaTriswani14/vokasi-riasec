<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\User;
use Illuminate\Support\Facades\Hash;

class KemendikdasmenUserSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        User::updateOrCreate(
            ['email' => 'admin@kemendikdasmen.go.id'], // Email login yang kamu minta
            [
                'name' => 'Otoritas Pusat Kemendikdasmen',
                'password' => Hash::make('kemendikdasmen2026'), // Password yang kamu minta
                'role' => 'kemendikdasmen', // Role khusus kementerian
            ]
        );
    }
}