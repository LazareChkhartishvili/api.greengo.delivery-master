<?php

namespace Database\Seeders;

use App\Models\UserRole;

use Illuminate\Database\Seeder;

class UserRoleSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        UserRole::create(
            [
                "id"             =>    "1",
                "name"           =>    "ადმინი",
                "code"           =>    "Admin",
                "color"          =>    "",
            ]
        );

        UserRole::create(
            [
                "id"             =>    "2",
                "name"           =>    "კურიერი",
                "code"           =>    "Courier",
                "color"          =>    "",
            ]
        );

        UserRole::create(
            [
                "id"             =>    "3",
                "name"           =>    "მენეჯერი",
                "code"           =>    "Manager",
                "color"          =>    "",
            ]
        );

        UserRole::create(
            [
                "id"             =>    "5",
                "name"           =>    "კომპანია",
                "code"           =>    "Company",
                "color"          =>    "",
            ]
        );

        UserRole::create(
            [
                "id"             =>    "6",
                "name"           =>    "მომხმარებელი",
                "code"           =>    "Member",
                "color"          =>    "",
            ]
        );

    }
}
