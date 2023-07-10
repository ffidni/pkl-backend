<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class PklStep extends Model
{
    use HasFactory;
    protected $table = "pkl_steps";

    protected $fillable = [
        "title",
        "dates",
        "order",
    ];
}