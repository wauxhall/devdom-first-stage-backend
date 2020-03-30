<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class StudyMaterialType extends Model
{
    public function study_material()
    {
        return $this->hasMany(StudyMaterial::class);
    }
}
