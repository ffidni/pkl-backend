<?php

namespace App\Services;

use App\Exceptions\ApiException;
use App\Mail\EmailConfirmationMail;
use App\Models\EmailConfirmationModel;
use Carbon\Carbon;
use Illuminate\Http\Response;
use App\Models\User;
use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Str;


class EmailConfirmationService
{

    function sendEmailRequest($email)
    {
        $currentDate = Carbon::now();
        $user = User::where("email", $email)->first();
        if (!$user) {
            throw new ApiException(Response::HTTP_NOT_FOUND, "Akun dengan email: $email, tidak ditemukan");
        }
        $tokenData = EmailConfirmationModel::where("user_id", $user->id)->where("expires_at", ">", $currentDate)->first();
        if ($tokenData) {
            throw new ApiException(Response::HTTP_BAD_REQUEST, "Tidak bisa mengirim link verifikasi akun karna anda sudah request beberapa waktu lalu, coba periksa email anda: $email");
        }

        $token = Str::random(60);
        $expires_at = $currentDate->addMinutes(60);

        EmailConfirmationModel::create(
            [
                "user_id" => $user->id,
                "token" => $token,
                "expires_at" => $expires_at,
            ]
        );
        Mail::to($user->email)->send(new EmailConfirmationMail($token), );
        return "Link verifikasi sudah dikirim ke email $email";

    }

    function activateEmail($token)
    {
        $currentDate = Carbon::now();
        $tokenData = EmailConfirmationModel::where("token", $token)->where("expires_at", ">", $currentDate)->first();
        if (!$tokenData) {
            throw new ApiException(Response::HTTP_BAD_REQUEST, "Token tidak ditemukan/expired");
        }
        $user = User::where("id", $tokenData->user_id)->first();
        if (!$user) {
            throw new ApiException(Response::HTTP_NOT_FOUND, "Akun tidak ditemukan");
        }
        $user->email_verified = 1;
        $user->save();
        $tokenData->delete();
        return "Email: " . $user->email . " berhasil dikonfirmasi!";
    }
}