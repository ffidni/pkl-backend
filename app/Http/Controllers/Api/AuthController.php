<?php

namespace App\Http\Controllers\Api;

use App\Exceptions\ApiException;
use App\Http\Controllers\Controller;
use App\Http\Resources\DefaultResource;
use App\Services\AuthService;
use Exception;
use Illuminate\Http\Request;
use Illuminate\Http\Response;

class AuthController extends Controller
{
    private $authService;

    public function __construct(AuthService $authService)
    {
        $this->authService = $authService;
    }
    public function register(Request $request)
    {
        $user = $this->authService->registerProcess($request->all());
        return new DefaultResource(Response::HTTP_OK, $user, null);
    }

    public function login(Request $request)
    {
        $credentials = $request->only("email", "password");
        $data = $this->authService->loginProcess($credentials);
        return new DefaultResource(Response::HTTP_OK, "Berhasil login", $data);
    }
}