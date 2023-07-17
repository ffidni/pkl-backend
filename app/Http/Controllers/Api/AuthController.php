<?php

namespace App\Http\Controllers\Api;

use App\Exceptions\ApiException;
use App\Http\Controllers\Controller;
use App\Http\Resources\DefaultResource;
use App\Services\AuthService;
use Illuminate\Http\Request;
use Illuminate\Http\Response;
use OpenApi\Annotations as OA;
use Tymon\JWTAuth\Facades\JWTAuth;

class AuthController extends Controller
{
    private $authService;

    public function __construct(AuthService $authService)
    {
        $this->authService = $authService;
    }

    /**
     * @OA\Post(
     *     path="/register",
     *     operationId="Register",
     *     tags={"Auth"},
     *     summary="Register",
     *     description="Register a new user.",
     *     @OA\RequestBody(
     *         description="User data",
     *         required=true,
     *         @OA\MediaType(
     *             mediaType="application/json",
     *             @OA\Schema(
     *                 type="object",
     *                 @OA\Property(
     *                     property="nama_lengkap",
     *                     description="Full name of the user",
     *                     type="string"
     *                 ),
     *                 @OA\Property(
     *                     property="email",
     *                     description="Email address of the user",
     *                     type="string"
     *                 ),
     *                 @OA\Property(
     *                     property="nis",
     *                     description="User's NIS",
     *                     type="string"
     *                 ),
     *                 @OA\Property(
     *                     property="password",
     *                     description="User password",
     *                     type="string"
     *                 )
     *             )
     *         )
     *     ),
     *     @OA\Response(
     *         response="200",
     *         description="Successful operation"
     *     ),
     *     @OA\Response(
     *         response="401",
     *         description="Unauthorized"
     *     )
     * )
     */
    public function register(Request $request)
    {
        $user = $this->authService->registerProcess($request->all());
        return new DefaultResource(Response::HTTP_OK, $user, null);
    }

    /**
     * @OA\Post(
     *     path="/login",
     *     operationId="Login",
     *     tags={"Auth"},
     *     summary="Login",
     *     description="Log in the user.",
     *     @OA\RequestBody(
     *         description="User credentials",
     *         required=true,
     *         @OA\MediaType(
     *             mediaType="application/json",
     *             @OA\Schema(
     *                 type="object",
     *                 @OA\Property(
     *                     property="email",
     *                     description="Email address of the user",
     *                     type="string"
     *                 ),
     *                 @OA\Property(
     *                     property="password",
     *                     description="User password",
     *                     type="string"
     *                 )
     *             )
     *         )
     *     ),
     *     @OA\Response(
     *         response="200",
     *         description="Successful operation"
     *     ),
     *     @OA\Response(
     *         response="401",
     *         description="Unauthorized"
     *     )
     * )
     */
    public function login(Request $request)
    {
        $credentials = $request->only("email", "password");
        $data = $this->authService->loginProcess($credentials);
        return new DefaultResource(Response::HTTP_OK, "Berhasil login", $data);
    }

    /**
     * @OA\Post(
     *     path="/logout",
     *     operationId="Logout",
     *     tags={"Auth"},
     *     summary="Logout",
     *     description="Log out the user.",
     *     security={{"bearerAuth": {}}},
     *     @OA\Response(
     *         response="200",
     *         description="Successful operation"
     *     ),
     *     @OA\Response(
     *         response="401",
     *         description="Unauthorized"
     *     )
     * )
     */
    public function logout()
    {
        JWTAuth::invalidate(JWTAuth::getToken());
        return new DefaultResource(Response::HTTP_OK, "Berhasil logout", null);
    }
}