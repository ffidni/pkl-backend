<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ResetPasswordToken extends Model
{
    use HasFactory;

    protected $fillable = [
        "users_id",
        "token",
        "expires_at",
    ];

    public function user()
    {
        return $this->belongsTo(User::class);
    }
}