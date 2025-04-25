<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Notifications\Notifiable;

class Role extends Model
{
    use HasFactory, Notifiable;

    protected $table = 'roles';
    protected $primaryKey = 'id_role';

    protected $fillable = [
        'name',
        'created_at',
    ];

    protected $casts = [
        'created_at' => 'datetime',
        'updated_at' => 'datetime',
    ];
    public function users()
    {
        return $this->belongsToMany(User::class, 'users_roles', 'roles_id_role', 'users_id_user');
    }
}
