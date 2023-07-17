<?php

namespace App\Http\Controllers;

use Illuminate\Foundation\Auth\Access\AuthorizesRequests;
use Illuminate\Foundation\Validation\ValidatesRequests;
use Illuminate\Routing\Controller as BaseController;
use OpenApi\Annotations as OA;


/**
 * @OA\Info(
 *     title="ePKL Backend API",
 *     version="1.0.0",
 *     description="Backend for ePKL mobile app",
 *     @OA\Contact(
 *         name="Muhamamd Haikal",
 *         email="realityinaship@gmail.com"
 *     )
 * )
 * @OA\Server(url="http://localhost:8000/api")
 * @OA\SecurityScheme(
 *      securityScheme="bearerAuth",
 *      type="http",
 *      scheme="bearer",
 *      description="Enter token in format (Bearer <token>)",
 *      name="Authorization",
 *      in="header"
 * )
 */



class Controller extends BaseController
{
    use AuthorizesRequests, ValidatesRequests;
}