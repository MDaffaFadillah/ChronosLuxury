<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\User;
use Illuminate\Support\Facades\Hash;

class AdminSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function up(): void
    {
        // Tetap menggunakan up atau run sesuai default Seeder Laravel (biasanya run)
    }

    public function run(): void
    {
        User::updateOrCreate(
            ['email' => 'admin@chronosluxury.com'],
            [
                'name' => 'Chronos Admin',
                'password' => Hash::make('password'),
                'role' => 'admin',
            ]
        );

        // Buat satu customer dummy untuk kemudahan testing
        User::updateOrCreate(
            ['email' => 'customer@chronosluxury.com'],
            [
                'name' => 'James Bond',
                'password' => Hash::make('password'),
                'role' => 'customer',
            ]
        );
    }
}
