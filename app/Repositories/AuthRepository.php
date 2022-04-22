<?php

namespace App\Repositories;

use App\Models\User;
use Illuminate\Support\Str;

class AuthRepository
{
    public function createUser($data)
    {
        User::create([
            'login' => $data['login'],
            'password' => bcrypt($data['password']),
        ]);
    }

    public function updateToken()
    {
        $token = Str::random(32);
        auth()->user()->update([
            'token' => $token,
        ]);
        return $token;
    }
}
