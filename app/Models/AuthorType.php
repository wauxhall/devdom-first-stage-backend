<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class AuthorType extends Model
{
    public function study_material()
    {
        return $this->hasMany(StudyMaterial::class);
    }
}
