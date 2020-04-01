<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class StudyMaterialCategory extends Model
{
    protected $table = 'study_material_categories';

    protected $fillable = [ 'parent_id', 'name', 'description' ];

    public function children()
    {
        return $this->hasMany(self::class, 'parent_id');
    }

    public function study_material()
    {
        return $this->belongsToMany(StudyMaterial::class, 'study_material_study_material_category');
    }
}
