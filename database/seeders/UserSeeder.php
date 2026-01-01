<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use App\Models\User;
use Illuminate\Support\Facades\Hash;

class UserSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        User::create([
            'user_code' => 'SA001',
            'first_name' => 'Super',
            'middle_name' => '',
            'last_name' => 'Admin',
            'full_name' => 'Super Admin',
            'email' => 'superadmin@example.com',
            'mobile' => '1234567890',
            'profile' => null,
            'password' => Hash::make('12345678'),
            'user_type' => 'super_admin',
            'email_verified' => 1,
            'mobile_verified' => 1,
            'is_active' => 1,
            'is_deleted' => 0,
            'deleted_at' => null,
        ]);
    }
}
