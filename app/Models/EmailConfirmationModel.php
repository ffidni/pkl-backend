<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class EmailConfirmationModel extends Model
{
    use HasFactory;

    protected $table = "email_confirmation";
    protected $fillable = [
        "token",
        "user_id",
        "expires_at"
    ];
}