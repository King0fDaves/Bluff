<?php

namespace App\Http\Controllers;

use App\Http\Requests\LoginUserRequest;
use App\Http\Requests\StoreUserRequest;
use App\Models\User;
use App\Traits\HttpResponse;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Cookie;
use Illuminate\Support\Facades\Hash;

class AuthController extends Controller
{
    use HttpResponse;

    public function login(LoginUserRequest $request)
    {
        $request->validated($request->all());

        if (!Auth::attempt($request->only('name', 'password'))) {
            return $this->error('', 'Credentials were incorrect', 404);
        }

        $user = User::where('name', $request->name)->first(); 

        return $this->success([
            'user' => $user,
            'token' => $user->createToken('Api Token of ' . $user->name)->plainTextToken
        ]);
    }

    public function register(StoreUserRequest $request)
    {
        $request->validated($request->all()); 
        if(User::where('name', $request->name)->exists()){
            return $this->error('', 'Username is in use', 409);
        }
        $user = User::create([
            'name' => $request->name,
            'password' => Hash::make($request->password),
        ]);

        return $this->success([
            'user' => $user,
            'token' => $user->createToken('API Token of ' . $user->name)->plainTextToken
        ]);
    }

    public function logout()
    { 
        Auth::user()->currentAccessToken()->delete(); 
        return $this->success('You have been successfully logged out');
    }

    public function getToken(){
        $token = Auth::user()->currentAccessToken();
        return $this->success($token);
    }
}