<?php

namespace App\Services\Auth;

use App\Contracts\Auth\AuthInterface;
use App\Http\Requests\Auth\LoginRequest;
use App\Http\Requests\Auth\RegisterRequest;
use App\Http\Resources\UserResource;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;

class AuthService implements AuthInterface
{
    public function createAccount(RegisterRequest $request)
    {
        $fields = $request->validated();

        $user = User::create([
            'name' => $fields['name'],
            'email' => $fields['email'],
            'password' => Hash::make($fields['password']),
        ]);

        if (!$user) {
            return [
                'success' => false,
                'message' => 'There was an error in creating your account',
            ];
        }

        return [
            'user' => new UserResource($user),
            'token' => $user->createToken('auth_token')->plainTextToken,
        ];
    }

    public function authenticate(LoginRequest $request)
    {
        $fields = $request->validated();

        $user = User::where('email', $fields['email'])->first();

        if (!$user || !Hash::check($fields['password'], $user->password)) {
            return [
                'message' => 'The credentials you entered did not match our records.',
            ];
        }

        return [
            'user' => new UserResource($user),
            'token' => $user->createToken('auth_token')->plainTextToken,
        ];
    }

    public function logout(Request $request)
    {
        $request->user()->tokens()->delete();

        return [
            'message' => 'You have been logged out',
        ];
    }
}
