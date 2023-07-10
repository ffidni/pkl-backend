<?php

namespace App\Http\Controllers\api;

use App\Http\Controllers\Controller;
use App\Http\Resources\DefaultResource;
use App\Services\EmailConfirmationService;
use Illuminate\Http\Request;
use Illuminate\Http\Response;

class EmailConfirmationController extends Controller
{

    protected $emailService;

    public function __construct(EmailConfirmationService $emailService)
    {
        $this->emailService = $emailService;
    }

    function sendEmailConfirmationRequest($email)
    {
        $status = $this->emailService->sendEmailRequest($email);
        return new DefaultResource(Response::HTTP_CREATED, $status, null);
    }

    function activateEmail($token)
    {
        $status = $this->emailService->activateEmail($token);
        return new DefaultResource(Response::HTTP_OK, $status, null);
    }
}