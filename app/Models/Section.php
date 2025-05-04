<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Section extends Model
{
    protected $table = 'sections';
    protected $primaryKey = 'id_sections';
    public $timestamps = true;

    protected $fillable = [
        'section_name', 'order_numbe', 'created_at', 'updated_at', 'created_by', 'updated_by'
    ];

    public function cases()
    {
        return $this->hasMany(CaseModel::class, 'sections_id_sections');
    }
}
