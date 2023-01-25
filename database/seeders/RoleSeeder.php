<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Spatie\Permission\Models\Role;
use Spatie\Permission\Models\Permission;

class RoleSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $roleOne = Role::create(['name' => 'Admin']);
        $roleTwo = Role::create(['name' => 'Comensal']);

        Permission::create(['name' => 'foods'])->assignRole($roleOne);
    }
}
