<?php

namespace Database\Seeders;

use App\Models\User;
use Illuminate\Support\Str;
use Illuminate\Database\Seeder;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;

class UserSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        User::factory()->create();

        // Create an admin user
        User::create(
            [
                'role' => 'Admin',
                'name' => 'Admin',
                'email' => 'admin@admin.com',
                'email_verified_at' => now(),
                'password' => bcrypt('adminadmin'),
                'remember_token' => Str::random(10),
            ]
        );
        User::create(
            [
                'role' => 'User',
                'name' => 'User',
                'email' => 'user@user.com',
                'email_verified_at' => now(),
                'password' => bcrypt('useruser'),
                'remember_token' => Str::random(10),
            ]
        );
    }
}
