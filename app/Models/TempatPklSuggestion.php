<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class TempatPklSuggestion extends Model
{
    use HasFactory;

    protected $table = "tempat_pkl_suggestions";
    protected $fillable = [
        "nama_tempat",
        "latitude",
        "longitude",
    ];
}