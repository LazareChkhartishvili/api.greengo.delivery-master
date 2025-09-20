<?php

namespace Database\Seeders;

use App\Models\User;
use App\Models\UserRole;
use App\Models\UserStatus;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;

class ProductionAdminSeeder extends Seeder
{
    /**
     * Run the database seeds for production environment.
     * This seeder ensures admin users exist on Railway deployment.
     *
     * @return void
     */
    public function run()
    {
        // Ensure UserRole and UserStatus exist first
        UserRole::firstOrCreate(
            ['id' => 1],
            [
                'name' => 'ადმინი',
                'code' => 'Admin',
                'color' => '',
            ]
        );

        UserStatus::firstOrCreate(
            ['id' => 1],
            [
                'name' => 'აქტიური',
                'code' => 'Active',
            ]
        );

        // Create main admin user
        User::firstOrCreate(
            ['email' => 'admin@greengo.delivery'],
            [
                'name' => 'Admin User',
                'password' => Hash::make('admin123'),
                'role_id' => 1, // Admin role
                'status_id' => 1, // Active status
                'email_verified_at' => now(),
            ]
        );

        // Create backup admin user with stronger password
        User::firstOrCreate(
            ['email' => 'superadmin@greengo.delivery'],
            [
                'name' => 'Super Admin',
                'password' => Hash::make('admin2024!'),
                'role_id' => 1, // Admin role
                'status_id' => 1, // Active status
                'email_verified_at' => now(),
            ]
        );

        // Create third admin user for redundancy
        User::firstOrCreate(
            ['email' => 'deploy@greengo.delivery'],
            [
                'name' => 'Deploy Admin',
                'password' => Hash::make('deploy2024!'),
                'role_id' => 1, // Admin role
                'status_id' => 1, // Active status
                'email_verified_at' => now(),
            ]
        );

        echo "✅ Production admin users created successfully!\n";
        echo "📧 Available admin accounts:\n";
        echo "   - admin@greengo.delivery (password: admin123)\n";
        echo "   - superadmin@greengo.delivery (password: admin2024!)\n";
        echo "   - deploy@greengo.delivery (password: deploy2024!)\n";
    }
}
