<?php

namespace Tests\Feature;

use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Illuminate\Support\Facades\Artisan;
use Illuminate\Support\Facades\Hash;
use Spatie\Permission\Contracts\Permission;
use Spatie\Permission\Contracts\Role;
use Spatie\Permission\PermissionRegistrar;
use Tests\TestCase;

class RegisterTest extends TestCase
{

    public function test_register_ok()
    {
        Artisan::call('db:seed');

        $this->post('api/register', [
            'name' => 'Testint test',
            'email' => 'test45@gmail.com',
            'password' => '123456',
            'password_confirmation' => '123456'
        ])->assertStatus(201);
    }

    public function test_register_return_error_message()
    {
        //Artisan::call('db:seed');

        $this->post('api/register', [
            'name' => 'Testint test',
            'password' => '123456',
            'password_confirmation' => '123456'
        ])->assertStatus(400);
    }
}
