<?php

namespace App\Services;

use App\Models\StudyMaterial;
use App\Services\Contracts\StudyMaterialLinkLogicInterface;
use App\Services\Contracts\StudyMaterialLogicInterface;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Support\Facades\DB;

class StudyMaterialService implements StudyMaterialLogicInterface
{
    private $response = [
        'success' => true,
        'data'    => [],
        'message' => ''
    ];

    private $studyMaterialLinkLogic;

    /**
     * StudyMaterialService constructor.
     * @param StudyMaterialLinkLogicInterface $logic
     */
    public function __construct(StudyMaterialLinkLogicInterface $logic) {
        $this->studyMaterialLinkLogic = $logic;
    }

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
        if(!empty($data['study_material_type_ids'])) {
            $query->where(function ($q) use ($data) {
                foreach($data['study_material_type_ids'] as $smt_id) {
                    $q->orWhere('study_material_type_id', $smt_id);
                }
            });
        }

        if(!empty($data['author_type_ids'])) {
            $query->where(function ($q) use ($data) {
                foreach($data['author_type_ids'] as $smt_id) {
                    $q->orWhere('author_type_ids', $smt_id);
                }
            });
        }

        if(!empty($data['created_date_start'])) {
            $query->where('created_at', '>=', $data['created_date_start']);

            if(!empty($data['created_date_end'])) {
                $query->where('created_at', '<=', $data['created_date_end']);
            }
        }

        if(!empty($data['category_ids'])) {
            $query->where(function ($qr) use ($data) {
                foreach($data['category_ids'] as $category_id) {
                    $qr->orWhereHas('category', function (Builder $q) use($category_id) {
                        $q->where('study_material_categories.id', $category_id);
                    });
                }
            });
        }

        if(!empty($data['searchword'])) {
            $query->where('name', 'LIKE', '%' . $data['searchword'] . '%');
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
            $this->response['data']    = [];
            $this->response['message'] = 'Учебный материал с id = ' . $id . ' не найден.';
        } else {
            $this->response['data']    = $result;
        }

        return $this->response;
    }

    /**
     * @param array $data
     * @return array
     */
    public function createStudyMaterial(array $data) : array
    {
        $create_data = [
            'study_material_type_id' => $data['study_material_type_id'],
            'author_type_id'         => $data['author_type_id'],
            'name'                   => $data['name'],
            'category_ids'           => $data['category_ids']
        ];

        if(!empty($data['description'])) {
            $create_data['description'] = $data['description'];
        } else {
            $create_data['description'] = '';
        }

        DB::beginTransaction();

        $study_material = StudyMaterial::create($create_data);

        $create_data['id'] = $study_material->id;

        if(!empty($data['links'])) {
            $links = [];

            foreach($data['links'] as $link) {
                $links[] = [
                    'study_material_id' => $create_data['id'],
                    'link' => $link
                ];
            }

            $create_data['links'] = $this->studyMaterialLinkLogic->createStudyMaterialLinks($links);
        }

        foreach($create_data['category_ids'] as $category_id) {
            StudyMaterial::find($create_data['id'])->category()->attach($create_data['id'], [ 'study_material_category_id' => $category_id ]);
        }

        DB::commit();

        $this->response['data'] = $create_data;
        $this->response['message'] = 'Учебный материал создан с id = ' . $create_data['id'];

        return $this->response;
    }

    /**
     * @param int $id
     * @param array $data
     * @return array
     */
    public function updateStudyMaterial(int $id, array $data) : array
    {
        if(empty($data)) {
           return $this->response;
        }

        $update_data = [];

        if(!empty($data['study_material_type_id'])) {
            $update_data['study_material_type_id'] = $data['study_material_type_id'];
        }

        if(!empty($data['author_type_id'])) {
            $update_data['author_type_id'] = $data['author_type_id'];
        }

        if(!empty($data['name'])) {
            $update_data['name'] = $data['name'];
        }

        if(!empty($data['description'])) {
            $update_data['description'] = $data['description'];
        }

        DB::beginTransaction();

        $rows_affected = StudyMaterial::where('id', $id)->update($update_data);

        if(empty($rows_affected)) {
            $this->response['success'] = false;
            $this->response['data']    = [];
            $this->response['message'] = 'Учебный материал с id = ' . $id . ' не найден. Данные не обновлены';

            return $this->response;
        }

        if(!empty($data['links'])) {
            $update_data['links'] = $data['links'];

            $this->studyMaterialLinkLogic->updateStudyMaterialLinks($update_data['links']);
        }

        if(!empty($data['category_ids'])) {
            $update_data['category_ids'] = $data['category_ids'];

            foreach($update_data['category_ids'] as $category_id) {
                StudyMaterial::find($id)->category()->sync([ $id => [ 'study_material_category_id' => $category_id ] ]);
            }
        }

        DB::commit();

        $update_data['id'] = $id;

        $this->response['data'] = $update_data;
        $this->response['message'] = 'Учебный материал с id = ' . $id . ' обновлен.';

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

        // Deleting study material. Links are deleted automatically by onDelete('cascade') event set in migration
        StudyMaterial::where('id', $id)->delete();

        $this->response['data'] = $id;
        $this->response['message'] = 'Учебный материал с id = ' . $id . ' удален.';

        return $this->response;
    }
}
