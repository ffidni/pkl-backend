<?php

namespace App\Services;

use App\Exceptions\ApiException;
use App\Models\User;
use Exception;
use Illuminate\Http\Response;
use Illuminate\Support\Facades\Validator;
use Tymon\JWTAuth\Exceptions\JWTException;
use Tymon\JWTAuth\Facades\JWTAuth;

class AuthService
{

    public function registerProcess(array $data)
    {
        $validator = Validator::make($data, [
            "nama_lengkap" => "required|string",
            "email" => "required|email",
            "nis" => "required|string|min:10|max:10",
            "password" => "required|string|min:6",
        ]);
        if ($validator->fails()) {
            $validatorData = validatorErrorHandler($validator);
            throw new ApiException(Response::HTTP_BAD_REQUEST, $validatorData['message'], $validatorData['errors']);
        }
        $user = User::where("email", $data['email'])->orWhere("nis", $data['nis'])->exists();
        if ($user) {
            throw new ApiException(Response::HTTP_BAD_REQUEST, "Email atau nis sudah digunakan akun lain");
        }

        $defaultPass = $data['password'];
        $data['password'] = bcrypt($data['password']);
        $user = User::create($data);
        $userResponse = $this->loginProcess(["email" => $data['email'], "password" => $defaultPass]);
        return $userResponse;
    }

    public function loginProcess(array $credentials)
    {
        $validator = Validator::make($credentials, [
            "email" => "required|email",
            "password" => "required|string|min:6",
        ]);

        if ($validator->fails()) {
            $validatorData = validatorErrorHandler($validator);
            throw new ApiException(Response::HTTP_BAD_REQUEST, $validatorData['message'], $validatorData['errors']);
        }
        $token = JWTAuth::attempt($credentials);
        if (!$token) {
            throw new ApiException(Response::HTTP_BAD_REQUEST, "Email atau password salah");
        }
        $userResponse = getUser($credentials['email']);
        $userResponse->token = $token;
        $userResponse->token_type = "bearer";
        $userResponse->token_expires_in = auth()->factory()->getTTL() * 60;

        return $userResponse;
    }

}