<?php

namespace Database\Seeders;

use App\Models\MedicalCase;
use App\Models\User;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;

class DatabaseSeeder extends Seeder
{
    public function run(): void
    {
        // Dummy password comes from .env (SEED_PASSWORD); see README for the login details.
        $password = Hash::make(env('SEED_PASSWORD', 'password'));

        $admin = User::factory()->create([
            'name' => 'Demo Admin',
            'email' => 'admin@example.com',
            'password' => $password,
            'role' => User::ROLE_ADMIN,
        ]);

        User::factory()->create([
            'name' => 'Demo Viewer',
            'email' => 'viewer@example.com',
            'password' => $password,
            'role' => User::ROLE_VIEWER,
        ]);

        // 25 dummy cases with readable numbers: CASE-0001 ... CASE-0025
        for ($i = 1; $i <= 25; $i++) {
            MedicalCase::factory()->create([
                'case_number' => 'CASE-'.str_pad((string) $i, 4, '0', STR_PAD_LEFT),
                'created_by' => $admin->id,
            ]);
        }
    }
}
