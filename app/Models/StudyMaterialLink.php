<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class StudyMaterialLink extends Model
{
    protected $fillable = [ 'study_material_id', 'link' ];

    public function study_material()
    {
        return $this->belongsTo(StudyMaterial::class);
    }
}
