<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class CaseItem extends Model
{
    protected $table = 'case_items';
    public $timestamps = false;

    protected $fillable = [
        'cases_id_case', 'items_id_item', 'drop_rate'
    ];


    public function case()
    {
        return $this->belongsTo(CaseModel::class, 'cases_id_case');
    }


    public function item()
    {
        return $this->belongsTo(Item::class, 'items_id_item');
    }
}
