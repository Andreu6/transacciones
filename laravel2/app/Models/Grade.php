<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Laravel\Sanctum\HasApiTokens;

class Grade extends Authenticatable
{
    use HasApiTokens, HasFactory, Notifiable;

    protected $table = "grade";

    protected $fillable = [
        'nombre_curso'
    ];

public $timestamps = false;

}
