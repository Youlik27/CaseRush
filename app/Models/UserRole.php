<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Notifications\Notifiable;

class UserRole extends Model
{
    /** @use HasFactory<\Database\Factories\UserFactory> */
    use HasFactory, Notifiable;

    /**
     * The attributes that are mass assignable.
     *
     * @var list<string>
     */
    protected $primaryKey = 'users_id_user';
    protected $fillable = [
        'roles_id_role',
        'assigned_at',
        'assigned_by',
        'active',
        'expired at',
    ];
    /**
     * The attributes that should be hidden for serialization.
     *
     * @var list<string>
     */
    protected $hidden = [
    ];
    /**
     * Get the attributes that should be cast.
     *
     * @return array<string, string>
     */
    protected function casts(): array
    {
        return [
            'assigned_at' => 'datetime',
            'expired_at' => 'datetime',
            'active' => 'boolean',
        ];
    }
    public function user()
    {
        return $this->belongsTo(User::class, 'users_id_user');
    }

    public function roles()
    {
        return $this->belongsToMany(Role::class, 'users_roles', 'user_id_user', 'role_id_role');
    }
}
