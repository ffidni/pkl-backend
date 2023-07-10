<?php

namespace App\Services;

use App\Exceptions\ApiException;
use App\Http\Resources\DefaultResource;
use App\Mail\ResetPasswordMail;
use App\Models\ResetPasswordToken;
use Carbon\Carbon;
use Illuminate\Http\Response;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Facades\Validator;
use App\Models\User;
use Illuminate\Support\Str;

class ForgotPasswordService
{


    function resetPassword(array $data)
    {
        $currentDate = Carbon::now();
        $validator = Validator::make($data, [
            "token" => "required|string",
            "password" => "required|string",
        ]);
        if ($validator->fails()) {
            $validatorData = validatorErrorHandler($data);
            throw new ApiException(Response::HTTP_BAD_REQUEST, $validatorData['message'], $validatorData['errors']);
        }
        $tokenData = ResetPasswordToken::where("token", $data['token'])->where("expires_at", ">", $currentDate)->first();
        if (!$tokenData) {
            throw new ApiException(Response::HTTP_NOT_FOUND, "Token tidak ditemukan/expired");
        }
        $user = User::where("id", $tokenData['users_id'])->first();
        if (!$user) {
            throw new ApiException(Response::HTTP_NOT_FOUND, "Akun dengan id: " . $tokenData->user . " tidak ditemukan!", null);
        }
        $user->password = bcrypt($data['password']);
        $user->save();
        $tokenData->delete();
        return $user;
        ;
    }

    function getResetTokenData($token, $dothrow = true)
    {
        $currentDate = Carbon::now();
        $data = ResetPasswordToken::where("token", $token)->where("expires_at", ">", $currentDate)->first();
        if (!$data && $dothrow) {
            throw new ApiException(Response::HTTP_NOT_FOUND, "Token tidak ditemukan/expired");
        }
        return $data;
    }

    function sendMail($email)
    {

        $user = User::where("email", $email)->first();
        if (!$user) {
            throw new ApiException(Response::HTTP_NOT_FOUND, "Akun dengan email: " . $email . " tidak ditemukan!", null);
        }
        $currentDate = Carbon::now();
        $dataToken = ResetPasswordToken::where("users_id", $user->id)->where("expires_at", ">", $currentDate)->first();

        if ($dataToken) {
            throw new ApiException(Response::HTTP_BAD_REQUEST, "Tidak bisa mengirim link reset password karna anda sudah request beberapa waktu lalu, coba periksa email anda: $email!", null);
        }
        $token = Str::random(60);
        $expiresAt = Carbon::now()->addMinutes(60);

        ResetPasswordToken::create([
            "users_id" => $user->id,
            "token" => $token,
            "expires_at" => $expiresAt
        ]);

        Mail::to($user->email)->send(new ResetPasswordMail($token));
        return "Link reset password telah dikirim ke email anda!";
    }

}