<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Http\Resources\DefaultResource;
use App\Services\EmailConfirmationService;
use Illuminate\Http\Request;
use Illuminate\Http\Response;
use OpenApi\Annotations as OA;

class EmailConfirmationController extends Controller
{
    protected $emailConfirmationService;

    public function __construct(EmailConfirmationService $emailConfirmationService)
    {
        $this->emailConfirmationService = $emailConfirmationService;
    }

    /**
     * @OA\Post(
     *     path="/send-email-confirmation/{email}",
     *     operationId="SendEmailConfirmationRequest",
     *     tags={"Email Confirmation"},
     *     summary="Send Email Confirmation Request",
     *     description="Send an email confirmation request to the specified email address.",
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
     *         description="Email confirmation request sent"
     *     ),
     *     @OA\Response(
     *         response="401",
     *         description="Unauthorized"
     *     )
     * )
     */
    public function sendEmailConfirmationRequest($email)
    {
        $status = $this->emailConfirmationService->sendEmailRequest($email);
        return new DefaultResource(Response::HTTP_CREATED, $status, null);
    }

    /**
     * @OA\Get(
     *     path="/activate-email/{token}",
     *     operationId="ActivateEmail",
     *     tags={"Email Confirmation"},
     *     summary="Activate Email",
     *     description="Activate the email using the provided token.",
     *     @OA\Parameter(
     *         name="token",
     *         in="path",
     *         description="Token received in the email confirmation request",
     *         required=true,
     *         @OA\Schema(
     *             type="string"
     *         )
     *     ),
     *     @OA\Response(
     *         response="200",
     *         description="Email successfully activated"
     *     ),
     *     @OA\Response(
     *         response="401",
     *         description="Unauthorized"
     *     )
     * )
     */
    public function activateEmail($token)
    {
        $view = $this->emailConfirmationService->activateEmail($token);
        return $view;
    }
}