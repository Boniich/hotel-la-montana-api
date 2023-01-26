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
    public function register(Request $request)
    {

        //1- Validar los datos

        $request->validate([
            'name' => 'required',
            'email' => 'required|email|unique:users',
            'password' => 'required|confirmed'
        ]);

        //2- Alta de usuario

        $user = new User();
        $user->name = $request->name;
        $user->email = $request->email;
        $user->password = Hash::make($request->password);
        $user->assignRole('Comensal')->save();

        //3- Respuesta

        return response($user, Response::HTTP_CREATED);
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
        //asegurar que sea solo el admin o alguien con role superior que pueda usar este metodo

        $request->validate([
            'roles' => 'required',
        ]);

        $user->roles()->sync($request->roles);

        return response(['message' => 'Roles successfully assigned']);
    }
}
