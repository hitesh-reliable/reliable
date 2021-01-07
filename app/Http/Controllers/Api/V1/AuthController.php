<?php

namespace App\Http\Controllers\Api\V1;

use App\Models\User;
use Illuminate\Support\Str;
use App\Http\Requests\Api\Login;
use App\Http\Requests\Api\Register;
use Illuminate\Support\Facades\Hash;
use App\Http\Controllers\Api\ApiController;

class AuthController extends ApiController {

    public function register(Register $request) {
        $input = request()->all();
        $input['password'] = Hash::make($input['password']);
        $userData = User::create($input);
        return $this->jsonResponse(true, 200, 'User Created', $userData);
    }

    public function login(Login $request) {
        $credential = [
            'email' => $request->input('email'),
            'password' => $request->input('password')
        ];
        if (auth()->attempt($credential)) {
            // Authentication passed...
            $user = auth()->user();
            $user->api_token = Str::random(80);
            $user->save();
            return $this->jsonResponse(true, 200, "Login Success", $user);
        }
        return $this->jsonResponse(false, 401, "Unauthenticated.", []);
    }

}
