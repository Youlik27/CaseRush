<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Item extends Model
{
    protected $table = 'items';
    protected $primaryKey = 'id_item';
    public $timestamps = false;

    protected $fillable = [
        'name', 'rarity', 'price', 'image_url'
    ];

    public function caseItems()
    {
        return $this->hasMany(CaseItem::class, 'items_id_item');
    }

    public function drops()
    {
        return $this->hasMany(Drop::class, 'items_id_item');
    }
}
