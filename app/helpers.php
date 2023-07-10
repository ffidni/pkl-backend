<?php
use App\Models\User;

function validatorErrorHandler($validator)
{
    $message = implode("\n", $validator->errors()->all());
    $errors = json_decode($validator->messages(), true);
    return ["message" => $message, "errors" => $errors];
}


function getUser($param)
{
    $user = User::where("id", $param)->orWhere("email", $param)->orWhere("nis", $param)->first();
    return $user;
}