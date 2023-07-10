<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Jurnal extends Model
{
    use HasFactory;
    protected $table = "jurnal";
    protected $fillable = [
        "users_id",
        "date",
        "title",
        "desc",
        "content",
    ];
}