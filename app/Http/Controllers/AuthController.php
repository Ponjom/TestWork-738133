<?php

namespace App\Http\Controllers;

use App\Http\Requests\LoginRequest;
use App\Http\Requests\RegisterRequest;
use App\Repositories\AuthRepository;
use Illuminate\Support\Facades\Auth;

class AuthController extends Controller
{
    private $authRepository;

    public function __construct(AuthRepository $authRepository)
    {
        $this->authRepository = $authRepository;
    }

    public function login(LoginRequest $request)
    {
        if (Auth::attempt($request->validated())) {
            $token = $this->authRepository->updateToken();
            auth()->user()->update();
            return response()->json(
                [
                    'status' => 'Success',
                    'message' => 'Succesfully login!',
                    'token' => $token,
                ]);
        }
        return response()->json(
            [
                'status' => 'Error',
                'message' => 'Login or password incorrect'
            ], 401);
    }

    public function register(RegisterRequest $request)
    {
        $this->authRepository->createUser($request->validated());

        return response()->json(
            [
                'status' => 'Success',
                'message' => 'Successfully registration'
            ]);
    }
}
