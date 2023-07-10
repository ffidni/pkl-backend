<?php

use App\Http\Controllers\Api\AuthController;
use App\Http\Controllers\api\EmailConfirmationController;
use App\Http\Controllers\api\ForgotPasswordController;
use App\Http\Controllers\Api\JurnalController;
use App\Http\Controllers\api\PklStepsController;
use App\Http\Controllers\Api\TempatPklController;
use App\Http\Controllers\Api\TempatPklSuggestionsController;
use App\Http\Controllers\Api\TugasController;
use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
|
| Here is where you can register API routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| is assigned the "api" middleware group. Enjoy building your API!
|
*/

Route::group(["middleware" => "jwt.verify"], function ($router) {
    Route::apiResource("/tugas", TugasController::class);
    Route::apiResource("/jurnal", JurnalController::class);
    Route::apiResource("/tempat-pkl", TempatPklController::class);
    Route::delete("/pkl-steps", [PklStepsController::class, "destroyAll"]);
});


Route::post("/forgot-password/{email}", [ForgotPasswordController::class, "sendForgotPasswordRequest"]);
Route::post("/get-token-data/{token}", [ForgotPasswordController::class, "getTokenData"]);
Route::get("/reset-password/{token}", [ForgotPasswordController::class, "resetPasswordForm"]);
Route::post("/reset-password", [ForgotPasswordController::class, "resetPassword"]);

Route::post("/send-email-confirmation/{email}", [EmailConfirmationController::class, "sendEmailConfirmationRequest"]);
Route::get("/activate-email/{token}", [EmailConfirmationController::class, "activateEmail"]);

Route::post("/register", [AuthController::class, "register"]);
Route::post("/login", [AuthController::class, "login"]);

Route::apiResource("/pkl-steps", PklStepsController::class);
Route::apiResource("/pkl-suggestions", TempatPklSuggestionsController::class);