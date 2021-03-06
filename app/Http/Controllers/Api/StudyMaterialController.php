<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Http\Requests\StudyMaterialCreateRequest;
use App\Http\Requests\StudyMaterialFilterRequest;
use App\Http\Requests\StudyMaterialUpdateRequest;
use App\Models\AuthorType;
use App\Models\StudyMaterialType;
use App\Services\Contracts\StudyMaterialLogicInterface;
use App\Traits\SendResponse;
use Illuminate\Http\JsonResponse;

class StudyMaterialController extends Controller
{
    use SendResponse;

    private $logic;

    /**
     * StudyMaterialController constructor.
     * @param StudyMaterialLogicInterface $studyMaterialLogic
     */
    public function __construct(StudyMaterialLogicInterface $studyMaterialLogic)
    {
        $this->logic = $studyMaterialLogic;
    }

    /**
     * @param StudyMaterialFilterRequest $request
     * @return JsonResponse
     */
    public function index(StudyMaterialFilterRequest $request) : JsonResponse
    {
        if(!empty($request->errors)) {
            return $this->sendError('Ошибка фильтрации данных.', $request->errors, 422);
        }

        $response = [
            'study_materials' => $this->logic->getStudyMaterials($request->all())
        ];

        if($request->has('with_filter_values')) {
            $response['author_types'] = AuthorType::all()->toArray();
            $response['study_material_types'] = StudyMaterialType::all()->toArray();
        }

        return $this->sendResponse($response, '');
    }

    /**
     * @param $id
     * @return JsonResponse
     */
    public function show($id) : JsonResponse
    {
        $response = $this->logic->getStudyMaterial(\intval($id));

        if(!$response['success']) {
            return $this->sendError('Возникли ошибки.', $response['data'], 422);
        }

        return $this->sendResponse($response['data'], $response['message']);
    }

    /**
     * @param StudyMaterialCreateRequest $request
     * @return JsonResponse
     */
    public function create(StudyMaterialCreateRequest $request) : JsonResponse
    {
        if(!empty($request->errors)) {
            return $this->sendError('Ошибка валидации данных.', $request->errors, 422);
        }

        $response = $this->logic->createStudyMaterial($request->all());

        if(!$response['success']) {
            return $this->sendError('Возникли ошибки.', $response['data'], 422);
        }

        return $this->sendResponse($response['data'], $response['message']);
    }

    /**
     * @param $id
     * @param StudyMaterialUpdateRequest $request
     * @return JsonResponse
     */
    public function update($id, StudyMaterialUpdateRequest $request) : JsonResponse
    {
        if(!empty($request->errors)) {
            return $this->sendError('Ошибка валидации данных.', $request->errors, 422);
        }

        $response = $this->logic->updateStudyMaterial(\intval($id), $request->all());

        if(!$response['success']) {
            return $this->sendError('Возникли ошибки.', $response['data'], 422);
        }

        return $this->sendResponse($response['data'], $response['message']);
    }

    /**
     * @param $id
     * @return JsonResponse
     */
    public function destroy($id) : JsonResponse
    {
        $response = $this->logic->deleteStudyMaterial(\intval($id));

        if(!$response['success']) {
            return $this->sendError('Возникли ошибки.', $response['data'], 422);
        }

        return $this->sendResponse($response['data'], $response['message']);
    }
}
