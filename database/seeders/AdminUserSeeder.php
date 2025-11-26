<?php

namespace Database\Seeders;

use App\Models\User;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;

class AdminUserSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        // Create admin user
        User::firstOrCreate(
            ['email' => 'admin@talent-website.com'],
            [
                'name' => 'Admin User',
                'email' => 'admin@talent-website.com',
                'password' => Hash::make('password123'),
                'role' => 'admin',
                'status' => 'active',
                'email_verified_at' => now(),
            ]
        );

        // Create test creator
        User::firstOrCreate(
            ['email' => 'creator@talent-website.com'],
            [
                'name' => 'Test Creator',
                'email' => 'creator@talent-website.com',
                'password' => Hash::make('password123'),
                'role' => 'creator',
                'status' => 'active',
                'email_verified_at' => now(),
            ]
        );

        // Create test member
        User::firstOrCreate(
            ['email' => 'member@talent-website.com'],
            [
                'name' => 'Test Member',
                'email' => 'member@talent-website.com',
                'password' => Hash::make('password123'),
                'role' => 'member',
                'status' => 'active',
                'email_verified_at' => now(),
            ]
        );

        $this->command->info('Test users created successfully!');
        $this->command->info('Admin: admin@talent-website.com / password123');
        $this->command->info('Creator: creator@talent-website.com / password123');
        $this->command->info('Member: member@talent-website.com / password123');
    }
}