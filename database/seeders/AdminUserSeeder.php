<?php

namespace Database\Seeders;

use App\Models\User;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;

class AdminUserSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        User::create([
            'name' => 'Admin User',
            'email' => 'admin@greengo.delivery',
            'password' => Hash::make('admin123'),
            'role_id' => 1, // Admin role
            'status_id' => 1, // Active status
            'email_verified_at' => now(),
        ]);
    }
}
