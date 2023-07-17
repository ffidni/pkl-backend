<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Http\Resources\DefaultResource;
use App\Services\ForgotPasswordService;
use Illuminate\Http\Request;
use Illuminate\Http\Response;
use OpenApi\Annotations as OA;

class ForgotPasswordController extends Controller
{
    protected $forgotPasswordService;

    public function __construct(ForgotPasswordService $forgotPasswordService)
    {
        $this->forgotPasswordService = $forgotPasswordService;
    }

    /**
     * @OA\Get(
     *     path="/reset-password-form/{token}",
     *     operationId="ResetPasswordForm",
     *     tags={"Forgot Password"},
     *     summary="Reset Password Form",
     *     description="Retrieve the reset password form using the provided token.",
     *     @OA\Parameter(
     *         name="token",
     *         in="path",
     *         description="Token received in the password reset request",
     *         required=true,
     *         @OA\Schema(
     *             type="string"
     *         )
     *     ),
     *     @OA\Response(
     *         response="200",
     *         description="Reset password form retrieved successfully"
     *     ),
     *     @OA\Response(
     *         response="401",
     *         description="Unauthorized"
     *     )
     * )
     */
    public function resetPasswordForm($token)
    {
        $data = $this->forgotPasswordService->getResetTokenData($token, false);
        return view("reset_password")->with(["resetTokenData" => $data]);
    }

    /**
     * @OA\Post(
     *     path="/send-forgot-password-request/{email}",
     *     operationId="SendForgotPasswordRequest",
     *     tags={"Forgot Password"},
     *     summary="Send Forgot Password Request",
     *     description="Send a forgot password request to the specified email address.",
     *     @OA\Parameter(
     *         name="email",
     *         in="path",
     *         description="Email address of the user",
     *         required=true,
     *         @OA\Schema(
     *             type="string"
     *         )
     *     ),
     *     @OA\Response(
     *         response="201",
     *         description="Forgot password request sent"
     *     ),
     *     @OA\Response(
     *         response="401",
     *         description="Unauthorized"
     *     )
     * )
     */
    public function sendForgotPasswordRequest($email)
    {
        $status = $this->forgotPasswordService->sendMail($email);
        return new DefaultResource(Response::HTTP_CREATED, $status, null);
    }

    /**
     * @OA\Post(
     *     path="/reset-password",
     *     operationId="ResetPassword",
     *     tags={"Forgot Password"},
     *     summary="Reset Password",
     *     description="Reset the password using the provided token and new password.",
     *     @OA\RequestBody(
     *         description="Reset password details",
     *         required=true,
     *         @OA\JsonContent(
     *             @OA\Property(
     *                 property="token",
     *                 type="string"
     *             ),
     *             @OA\Property(
     *                 property="password",
     *                 type="string",
     *                 format="password"
     *             )
     *         )
     *     ),
     *     @OA\Response(
     *         response="200",
     *         description="Password reset successfully"
     *     ),
     *     @OA\Response(
     *         response="401",
     *         description="Unauthorized"
     *     )
     * )
     */
    public function resetPassword(Request $request)
    {
        $user = $this->forgotPasswordService->resetPassword($request->all());
        return new DefaultResource(Response::HTTP_OK, "Berhasil merubah password!", $user);
    }

    /**
     * @OA\Get(
     *     path="/get-token-data/{token}",
     *     operationId="GetTokenData",
     *     tags={"Forgot Password"},
     *     summary="Get Token Data",
     *     description="Retrieve the data associated with the provided token.",
     *     @OA\Parameter(
     *         name="token",
     *         in="path",
     *         description="Token received in the password reset request",
     *         required=true,
     *         @OA\Schema(
     *             type="string"
     *         )
     *     ),
     *     @OA\Response(
     *         response="200",
     *         description="Reset token data retrieved successfully"
     *     ),
     *     @OA\Response(
     *         response="401",
     *         description="Unauthorized"
     *     )
     * )
     */
    public function getTokenData($token)
    {
        $data = $this->forgotPasswordService->getResetTokenData($token);
        return new DefaultResource(Response::HTTP_OK, "Berhasil mendapatkan data", $data);
    }
}