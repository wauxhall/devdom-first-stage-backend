<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class StudyMaterial extends Model
{
    protected $fillable = [ 'study_material_type_id', 'author_type_id', 'name', 'description' ];

    public function categories()
    {
        return $this->belongsToMany(StudyMaterialCategory::class, 'study_material_categories');
    }
}
