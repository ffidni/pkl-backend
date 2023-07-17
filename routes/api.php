<?php



use App\Http\Controllers\Api\AuthController;
use App\Http\Controllers\Api\EmailConfirmationController;
use App\Http\Controllers\Api\ForgotPasswordController;
use App\Http\Controllers\Api\JurnalController;
use App\Http\Controllers\Api\PklStepsController;
use App\Http\Controllers\Api\TempatPklController;
use App\Http\Controllers\Api\TempatPklSuggestionsController;
use App\Http\Controllers\Api\TugasController;
use Dingo\Api\Routing\Router;

$api = app(Router::class);

$api->version('v1', function ($api) {
    $api->group(["middleware" => "jwt.verify"], function ($api) {
        $api->resource("tugas", TugasController::class);
        $api->resource("jurnal", JurnalController::class);
        $api->resource("tempat-pkl", TempatPklController::class);
        $api->resource("/pkl-steps", PklStepsController::class);
        $api->delete("/pkl-steps", [PklStepsController::class, "destroyAll"]);
        $api->resource("/pkl-suggestions", TempatPklSuggestionsController::class);
        $api->post("/logout", [AuthController::class, "logout"]);
    });

    $api->post("/forgot-password/{email}", [ForgotPasswordController::class, "sendForgotPasswordRequest"]);
    $api->post("/get-token-data/{token}", [ForgotPasswordController::class, "getTokenData"]);
    $api->get("/reset-password/{token}", [ForgotPasswordController::class, "resetPasswordForm"]);
    $api->post("/reset-password", [ForgotPasswordController::class, "resetPassword"]);

    $api->post("/send-email-confirmation/{email}", [EmailConfirmationController::class, "sendEmailConfirmationRequest"]);
    $api->get("/activate-email/{token}", [EmailConfirmationController::class, "activateEmail"]);

    $api->post("/register", [AuthController::class, "register"]);
    $api->post("/login", [AuthController::class, "login"]);
});