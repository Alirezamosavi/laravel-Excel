<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Project extends Model
{
    use HasFactory;
    protected $casts = [
        'cost' => 'float'
    ];

    protected $fillable = [
        'name',
        'introduction',
        'created_at',
        'location',
        'cost'
    ];
}
