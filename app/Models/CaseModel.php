<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class CaseModel extends Model
{
    protected $table = 'cases';
    protected $primaryKey = 'id_case';
    public $timestamps = true;

    protected $fillable = [
        'name', 'price', 'description', 'image_url', 'order_number', 'sections_id_sections', 'created_by', 'updated_by', 'created_at', 'updated_at'
    ];

    public function section()
    {
        return $this->belongsTo(Section::class, 'sections_id_sections');
    }

    public function caseItems()
    {
        return $this->hasMany(CaseItem::class, 'cases_id_case');
    }
}
