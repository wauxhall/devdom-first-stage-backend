<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class StudyMaterial extends Model
{
    protected $fillable = [ 'study_material_type_id', 'author_type_id', 'name', 'description' ];

    public function category()
    {
        return $this->belongsToMany(StudyMaterialCategory::class, 'study_material_study_material_category');
    }

    public function study_material_link()
    {
        return $this->hasMany(StudyMaterialLink::class);
    }

    public function study_material_type()
    {
        return $this->belongsTo(StudyMaterialType::class);
    }

    public function author_type()
    {
        return $this->belongsTo(AuthorType::class);
    }
}
