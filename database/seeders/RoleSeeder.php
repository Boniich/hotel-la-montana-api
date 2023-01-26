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
        $adminRole = Role::create(['name' => 'Admin']);
        $comensalRole = Role::create(['name' => 'Comensal']);

        //User
        Permission::create(['name' => 'admin-can-change-roles'])->assignRole($adminRole);

        //Food
        Permission::create(['name' => 'index'])->syncRoles([$adminRole, $comensalRole]);
        Permission::create(['name' => 'show'])->syncRoles([$adminRole, $comensalRole]);

        Permission::create(['name' => 'store'])->assignRole($adminRole);
        Permission::create(['name' => 'update'])->assignRole($adminRole);
        Permission::create(['name' => 'destroy'])->assignRole($adminRole);
    }
}
