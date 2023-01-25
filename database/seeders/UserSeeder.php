<?php

namespace Database\Seeders;

use App\Models\User;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class UserSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $user = new User();

        $user->name = "Comensal";
        $user->email = "test@gmail.com";
        $user->password = "123456";

        $user->save();

        $admin = new User();

        $admin->name = "Admin";
        $admin->email = "admin@gmail.com";
        $admin->password = "123456";

        $admin->save();
    }
}
