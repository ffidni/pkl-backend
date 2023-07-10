<?php

namespace App\Http\Controllers\api;

use App\Http\Controllers\Controller;
use App\Http\Resources\DefaultResource;
use App\Services\ForgotPasswordService;
use Illuminate\Http\Request;
use Illuminate\Http\Response;

class ForgotPasswordController extends Controller
{
    protected $forgotPasswordServices;

    public function __construct(ForgotPasswordService $forgotPasswordServices)
    {
        $this->forgotPasswordServices = $forgotPasswordServices;
    }

    public function resetPasswordForm($token)
    {
        $data = $this->forgotPasswordServices->getResetTokenData($token, false);
        return view("reset_password")->with(["resetTokenData" => $data]);
    }

    public function sendForgotPasswordRequest($email)
    {
        $status = $this->forgotPasswordServices->sendMail($email);
        return new DefaultResource(Response::HTTP_CREATED, $status, null);
    }

    public function resetPassword(Request $request)
    {
        $user = $this->forgotPasswordServices->resetPassword($request->all());
        return new DefaultResource(Response::HTTP_OK, "Berhasil merubah password!", $user);
    }

    public function getTokenData($token)
    {
        $data = $this->forgotPasswordServices->getResetTokenData($token);
        return new DefaultResource(response::HTTP_OK, "Berhasil mendapatkan data", $data);
    }

}