<?php

namespace App\Services;

use App\Models\StudyMaterial;
use App\Services\Contracts\StudyMaterialLogicInterface;
use Illuminate\Database\Eloquent\Builder;

class StudyMaterialService implements StudyMaterialLogicInterface
{
    private $response = [
        'success' => true,
        'data'    => [],
        'message' => ''
    ];

    /**
     * @param array $filter_data
     * @return array
     */
    public function getStudyMaterials(array $filter_data = []) : array
    {
        $study_materials = StudyMaterial::with('category', 'study_material_link', 'study_material_type', 'author_type');

        if(!empty($filter_data)) {
            $study_materials = self::filter($study_materials, $filter_data);
        }

        return $study_materials->get()->toArray();
    }

    /**
     * @param Builder $query
     * @param array $data
     * @return Builder
     */
    public static function filter(Builder $query, array $data) : Builder
    {
        if(!empty($data['study_material_type'])) {
            foreach($data['study_material_type'] as $smt_id) {
                $query->where('study_material_type_id', $smt_id);
            }
        }

        if(!empty($data['author_type'])) {
            foreach($data['author_type'] as $at_id) {
                $query->where('author_type_id', $at_id);
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
                    $q->where('study_material_categories.id', $category_id);
                })->get();
            }
        }

        return $query;
    }

    /**
     * @param int $id
     * @return array
     */
    public function getStudyMaterial(int $id) : array
    {
        if($id === 0) {
            $this->response['success'] = false;
            $this->response['data']    = 'Не указан id учебного материала!';
            $this->response['message'] = 'Ошибка.';

            return $this->response;
        }

        $result = StudyMaterial::with('category', 'study_material_link', 'study_material_type', 'author_type')->where('id', $id)->get()->toArray();

        if(empty($result)) {
            $this->response['success'] = false;
            $this->response['data']    = 'Учебный материал с id = ' . $id . ' не найден.';
            $this->response['message'] = 'Ошибка.';
        } else {
            $this->response['data']    = $result;
        }

        return $this->response;
    }

    /**
     * @param int $id
     * @return array
     */
    public function deleteStudyMaterial(int $id) : array
    {
        $study_material = $this->getStudyMaterial($id);

        if(!$study_material['success']) {
            return $study_material;
        }

        $affectedRows = StudyMaterial::where('id', $id)->delete();

        $this->response['data'] = $affectedRows;

        return $this->response;
    }

    public function createStudyMaterial(array $data) : array
    {
        // TODO: Implement createStudyMaterial() method.
    }

    public function updateStudyMaterial(array $data) : array
    {
        // TODO: Implement updateStudyMaterial() method.
    }
}
