<?php

namespace Database\Seeders;

use App\Models\User;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;

class SuperAdminSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        User::updateOrCreate(
            [
                'email' => 'nguyenkhanhnguyenk3@gmail.com',
                'username' => 'Super Admin',
                'password' => Hash::make('Admin123@'),
                'phone' => '123456789',
                'role_id' => 1,
                'user_type' => 'super-admin',
                'is_active' => 1,
                'status' => 1,
                'email_verified_at' => now(),
            ]
        );
    }
}
