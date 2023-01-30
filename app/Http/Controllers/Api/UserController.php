<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\User;
use Symfony\Component\HttpFoundation\Response;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Cookie;

class UserController extends Controller
{

    public function __construct()
    {
        $this->middleware('can:admin-can-change-roles')->only('changeRole');
    }

    public function register(Request $request)
    {
        try {

            $request->validate([
                'name' => 'required',
                'email' => 'required|email|unique:users',
                'password' => 'required|confirmed'
            ]);

            $user = new User();
            $user->name = $request->name;
            $user->email = $request->email;
            $user->password = Hash::make($request->password);
            $user->assignRole('Comensal')->save();

            return response($user, Response::HTTP_CREATED);
        } catch (\Throwable $th) {
            return response(["Error" => "Register failed"], Response::HTTP_BAD_REQUEST);
        }
    }

    public function login(Request $request)
    {

        $credentials = $request->validate([
            'email' => 'required|email',
            'password' => 'required',
        ]);

        if (Auth::attempt($credentials)) {
            $user = Auth::user();
            $token = $user->createToken('token')->plainTextToken;
            return response(['token' => $token], Response::HTTP_OK);
        } else {
            return response(['message' => 'Invalid Credentials'], Response::HTTP_UNAUTHORIZED);
        }
    }

    public function changeRole(Request $request, User $user)
    {

        $request->validate([
            'roles' => 'required',
        ]);

        $user->roles()->sync($request->roles);

        return response(['message' => 'Roles successfully assigned']);
    }
}
