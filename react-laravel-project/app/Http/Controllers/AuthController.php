<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Http\Requests\LoginRequest;
use App\Http\Requests\SignupRequest;
use App\Models\User;
use Illuminate\Support\Facades\Auth;
use Tymon\JWTAuth\Facades\JWTAuth;

class AuthController extends Controller
{
    public function signup(SignupRequest $request)
    {
        $data = $request->validated();
        /** @var \App\Models\User $user */
        $user = User::create([
            'name' => $data['name'],
            'address' => $data['address'],
            'email' => $data['email'],
            'role' => 'user',
            'password' => bcrypt($data['password']),
        ]);

        // Генерация JWT токена для нового пользователя
        $token = JWTAuth::fromUser($user);

        return $this->respondWithToken($token);
    }

    public function login(LoginRequest $request)
{
    $credentials = $request->validated();
    if (!$token = JWTAuth::attempt($credentials)) {
        return response([
            'message' => 'Указанный адрес электронной почты или пароль неверны'
        ], 422);
    }

    /** @var \App\Models\User $user */
    $user = Auth::user();
    return $this->respondWithToken($token);
}

    public function logout(Request $request)
    {
        /** @var \App\Models\User $user */
        $user = $request->user();
        auth()->logout();

        return response('', 204);
    }

    protected function respondWithToken($token)
{
    /** @var \App\Models\User $user */
    $user = Auth::user();

    return response()->json([
        'access_token' => $token,
        'token_type' => 'bearer',
        'expires_in' => JWTAuth::factory()->getTTL() * 60,
        'user' => $user
    ]);
}
}