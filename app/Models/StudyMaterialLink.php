<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class StudyMaterialLink extends Model
{
    public function study_material()
    {
        return $this->belongsTo(StudyMaterial::class);
    }
}
