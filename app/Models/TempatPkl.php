<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class TempatPkl extends Model
{
    use HasFactory;
    protected $table = "tempat_pkl";
    protected $fillable = [
        "users_id",
        "latitude",
        "longitude",
    ];
}