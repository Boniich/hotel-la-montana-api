<?php

namespace Tests\Feature;

use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Illuminate\Support\Facades\Hash;
use Tests\TestCase;

class LoginTest extends TestCase
{

    use RefreshDatabase;

    public function test_login_ok()
    {

        $user = new User();

        $user->name = "test";
        $user->email = "admin3@gmail.com";
        $user->password = Hash::make('123456');

        $user->save();


        $reponse = $this->post('api/login', [
            'email' => 'admin3@gmail.com',
            'password' => '123456',
        ]);

        $reponse->assertStatus(200);
    }

    public function test_login_return_token_successfully()
    {

        $user = new User();

        $user->name = "test";
        $user->email = "admin3@gmail.com";
        $user->password = Hash::make('123456');

        $user->save();

        $reponse = $this->post('api/login', [
            'email' => 'admin3@gmail.com',
            'password' => '123456',
        ]);

        $reponse->assertJsonStructure(['token'])->assertStatus(200);
    }

    public function test_login_return_validation_error()
    {

        $reponse = $this->post('api/login', [
            'email' => 'NotExistsUser@gmail.com',
            'password' => '123456',
        ]);

        $reponse->assertJsonStructure([
            "message"
        ])->assertStatus(401);
    }
}
