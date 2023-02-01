<?php

namespace Tests\Feature;

use App\Models\Food;
use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Illuminate\Support\Arr;
use Illuminate\Support\Facades\Artisan;
use Illuminate\Support\Facades\Hash;
use Laravel\Sanctum\Sanctum;
use Spatie\Permission\Models\Permission;
use Spatie\Permission\Models\Role;
use Tests\TestCase;

class FoodTest extends TestCase
{
    use RefreshDatabase;

    public function test_show_all_foods_successfully()
    {
        Artisan::call('db:seed');

        $user = new User();

        $user->name = "Comensal";
        $user->email = "test455@gmail.com";
        $user->password = Hash::make('123456');

        $user->assignRole('Admin')->save();

        Sanctum::actingAs($user);

        $response = $this->get('api/foods');


        $response->assertStatus(200);
    }

    public function test_show_foods_by_id_successfully()
    {

        $adminRole = Role::create(['name' => 'Admin']);
        $comensalRole = Role::create(['name' => 'Comensal']);
        Permission::create(['name' => 'show'])->syncRoles([$adminRole, $comensalRole]);

        $food = new Food();

        $food->name = "Hamburgesa";
        $food->description = "Clasica hamburgesa argentina";
        $food->image = "image";
        $food->price = 10.5;
        $food->preparation_time = 5.5;

        $food->save();


        $user = new User();

        $user->name = "Comensal";
        $user->email = "test455@gmail.com";
        $user->password = Hash::make('123456');

        $user->assignRole('Admin')->save();

        Sanctum::actingAs($user);

        $response = $this->get('api/foods/' . $food->id);

        $response->assertJsonStructure(["id", "name"])->assertStatus(200);
    }
}
