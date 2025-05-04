<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Drop extends Model
{
    protected $table = 'drops';
    protected $primaryKey = 'id_drop';
    public $timestamps = false;

    protected $fillable = [
        'drop_date', 'users_id_user', 'cases_id_case', 'items_id_item'
    ];

    public function case()
    {
        return $this->belongsTo(CaseModel::class, 'cases_id_case');
    }

    public function item()
    {
        return $this->belongsTo(Item::class, 'items_id_item');
    }

    public function user()
    {
        return $this->belongsTo(User::class, 'users_id_user');
    }
}
