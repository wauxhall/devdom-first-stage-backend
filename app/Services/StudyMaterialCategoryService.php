<?php

namespace App\Services;

use App\Models\StudyMaterialCategory;
use App\Services\Contracts\StudyMaterialCategoryLogicInterface;
use App\Services\Contracts\StudyMaterialLogicInterface;
use Illuminate\Database\Eloquent\Builder;

class StudyMaterialCategoryService implements StudyMaterialCategoryLogicInterface
{
    private $response = [
        'success' => true,
        'data'    => [],
        'message' => ''
    ];

    private $studyMaterialLogic;

    /**
     * StudyMaterialService constructor.
     * @param StudyMaterialLogicInterface $logic
     */
    public function __construct(StudyMaterialLogicInterface $logic) {
        $this->studyMaterialLogic = $logic;
    }

    /**
     * @param array $filter_data
     * @return array
     */
    public function getCategories(array $filter_data = []) : array
    {
        $study_materials = StudyMaterialCategory::query();

        if(!empty($filter_data)) {
            $study_materials = self::filter($study_materials, $filter_data);
        }

        return $study_materials->where('parent_id', null)->get()->toArray();
    }

    /**
     * @param Builder $query
     * @param array $data
     * @return Builder
     */
    public static function filter(Builder $query, array $data) : Builder
    {
        if(!empty($data['searchword'])) {
            $query->where('name', 'LIKE', '%' . $data['searchword'] . '%');
        }

        return $query;
    }

    /**
     * @param int $id
     * @return array
     */
    public function getCategory(int $id) : array
    {
        if($id === 0) {
            $this->response['success'] = false;
            $this->response['data']    = 'Не указан id категории!';
            $this->response['message'] = 'Ошибка.';

            return $this->response;
        }

        $category = StudyMaterialCategory::query()->where('id', $id)->get()->toArray();

        if(empty($category)) {
            $this->response['success'] = false;
            $this->response['data']    = [];
            $this->response['message'] = 'Категория с id = ' . $id . ' не найдена.';
        } else {
            $this->response['data'] = $category;
        }

        return $this->response;
    }

    /**
     * @param int $id
     * @return array
     */
    public function getCategoryWithStudyMaterials(int $id) : array
    {
        $category = $this->getCategory($id);

        if(!$category['success']) {
            return $category;
        }

        $study_materials = $this->studyMaterialLogic->getStudyMaterials([ 'category_ids' => [ $id ] ]);

        $this->response['data'] = [
            'category_info'   => $category['data'],
            'study_materials' => $study_materials
        ];

        return $this->response;
    }

    /**
     * @param array $data
     * @return array
     */
    public function createCategory(array $data) : array
    {
        $create_data = [
            'name' => $data['name']
        ];

        if(!empty($data['parent_id'])) {
            $create_data['parent_id'] = $data['parent_id'];
        }

        $study_material = StudyMaterialCategory::create($create_data);

        $create_data['id'] = $study_material->id;

        $this->response['data'] = $create_data;
        $this->response['message'] = 'Категория создана с id = ' . $create_data['id'];

        return $this->response;
    }

    /**
     * @param int $id
     * @param array $data
     * @return array
     */
    public function updateCategory(int $id, array $data) : array
    {
        if(empty($data)) {
            return $this->response;
        }

        $update_data = [];

        if(!empty($data['name'])) {
            $update_data['name'] = $data['name'];
        }

        if(!empty($data['parent_id'])) {
            $update_data['parent_id'] = $data['parent_id'];
        }

        $rows_affected = StudyMaterialCategory::where('id', $id)->update($update_data);

        if(empty($rows_affected)) {
            $this->response['success'] = false;
            $this->response['data']    = [];
            $this->response['message'] = 'Категория с id = ' . $id . ' не найдена. Данные не обновлены';
        } else {
            $update_data['id'] = $id;

            $this->response['data'] = $update_data;
            $this->response['message'] = 'Категория с id = ' . $id . ' обновлена.';
        }

        return $this->response;
    }

    /**
     * @param int $id
     * @return array
     */
    public function deleteCategory(int $id) : array
    {
        $category = $this->getCategory($id);

        if(!$category['success']) {
            return $category;
        }

        StudyMaterialCategory::where('parent_id', $id)->update([ 'parent_id' => null ]);

        StudyMaterialCategory::where('id', $id)->delete();

        $this->response['data'] = $id;
        $this->response['message'] = 'Категория с id = ' . $id . ' удалена.';

        return $this->response;
    }
}
