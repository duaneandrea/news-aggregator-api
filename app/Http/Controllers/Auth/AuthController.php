<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Http\Requests\Auth\LoginRequest;
use App\Http\Requests\Auth\RegisterRequest;
use App\Services\Auth\AuthService;
use Illuminate\Http\Request;

class AuthController extends Controller
{
    public function __construct(protected AuthService $authService)
    {
    }

    public function register(RegisterRequest $request)
    {
        $response = $this->authService->createAccount($request);

        if (isset($response['success']) && !$response['success']) {
            return response()->json($response, 401);
        }

        return response()->json($response, 201);
    }

    public function login(LoginRequest $request)
    {
        $response = $this->authService->authenticate($request);

        if (isset($response['message'])) {
            return response()->json($response, 401);
        }

        return response()->json($response);
    }

    public function logout(Request $request)
    {
        $response = $this->authService->logout($request);

        return response()->json($response, 201);
    }
}
