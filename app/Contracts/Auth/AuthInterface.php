<?php

namespace App\Contracts\Auth;

use App\Http\Requests\Auth\LoginRequest;
use App\Http\Requests\Auth\RegisterRequest;
use Illuminate\Http\Request;

interface AuthInterface
{
    public function createAccount(RegisterRequest $request);
    public function authenticate(LoginRequest $request);
    public function logout(Request $request);
}
