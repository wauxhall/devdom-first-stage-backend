<?php

namespace App\Services;

use App\Models\StudyMaterial;
use App\Services\Contracts\StudyMaterialLogicInterface;
use Illuminate\Database\Eloquent\Builder;

class StudyMaterialService implements StudyMaterialLogicInterface
{
    public function getStudyMaterials(array $filter_data = []) : array
    {
        $study_materials = StudyMaterial::with('categories');

        if(!empty($filter_data)) {
            $study_materials = self::filter($study_materials, $filter_data);
        }

        return $study_materials->get()->toArray();
    }

    public static function filter(Builder $query, array $data) : Builder
    {
        if(!empty($data['study_material_type'])) {
            foreach($data['study_material_type'] as $smt_id) {
                $query->where('study_material_type_id', '=', $smt_id);
            }
        }

        if(!empty($data['author_type'])) {
            foreach($data['author_type'] as $at_id) {
                $query->where('author_type_id', '=', $at_id);
            }
        }

        if(!empty($data['created_date_start'])) {
            $query->where('created_at', '>=', $data['created_date_start']);

            if(!empty($data['created_date_end'])) {
                $query->where('created_at', '<=', $data['created_date_end']);
            }
        }

        if(!empty($data['category'])) {
            foreach($data['category'] as $category_id) {
                $query->whereHas('categories', function (Builder $q) use($category_id) {
                    $q->where('study_material_categories.id', '=', $category_id);
                })->get();
            }
        }

        return $query;
    }

    public function createStudyMaterial(array $data): array
    {
        // TODO: Implement createStudyMaterial() method.
    }

    public function getStudyMaterial(int $id): array
    {
        // TODO: Implement getStudyMaterial() method.
    }

    public function updateStudyMaterial(array $data): array
    {
        // TODO: Implement updateStudyMaterial() method.
    }

    public function deleteStudyMaterial(int $id): array
    {
        // TODO: Implement deleteStudyMaterial() method.
    }
}
