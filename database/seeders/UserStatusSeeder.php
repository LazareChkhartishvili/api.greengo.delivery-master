<?php

namespace Database\Seeders;

use App\Models\UserStatus;

use Illuminate\Database\Seeder;

class UserStatusSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        UserStatus::create(
            [
                "id"             =>    "1",
                "name"           =>    "აქტიური",
                "code"           =>    "Active",
            ]
        );

        UserStatus::create(
            [
                "id"             =>    "2",
                "name"           =>    "გაუქმებული",
                "code"           =>    "Inactive",
            ]
        );

    }
}
