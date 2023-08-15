<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class AccessCode extends Model
{
    protected $fillable = [
         'access_code',"created_at", // Add other fillable fields if needed
    ];
}
