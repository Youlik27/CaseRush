<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Notifications\Notifiable;

class CS_Case extends Model
{
    use HasFactory, Notifiable;

    protected $table = 'cases';
    protected $primaryKey = 'id_case';

    protected $fillable = [
        'name',
        'price',
        'description',
        'image_url',
        'created_by',
        'updated_by',
        'created_at',
        'updated_at',
    ];

    protected $casts = [
        'price' => 'float',
        'created_at' => 'datetime',
        'updated_at' => 'datetime',
    ];
}
