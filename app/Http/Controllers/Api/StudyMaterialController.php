<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Http\Requests\StudyMaterialCreateRequest;
use App\Http\Requests\StudyMaterialFilterRequest;
use App\Http\Requests\StudyMaterialUpdateRequest;
use App\Services\Contracts\StudyMaterialLogicInterface;
use App\Traits\SendResponse;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use function intval;

class StudyMaterialController extends Controller
{
    use SendResponse;

    /**
     * @param StudyMaterialLogicInterface $studyMaterialLogic
     * @param StudyMaterialFilterRequest $request
     * @return JsonResponse
     */
    public function index(StudyMaterialLogicInterface $studyMaterialLogic, StudyMaterialFilterRequest $request) : JsonResponse
    {
        if(!empty($request->errors)) {
            return $this->sendError('Ошибка фильтрации данных.', $request->errors, 422);
        }

        $response = $studyMaterialLogic->getStudyMaterials($request->all());

        return $this->sendResponse($response, '');
    }

    /**
     * @param StudyMaterialLogicInterface $studyMaterialLogic
     * @param Request $request
     * @return JsonResponse
     */
    public function show(StudyMaterialLogicInterface $studyMaterialLogic, Request $request) : JsonResponse
    {
        $response = $studyMaterialLogic->getStudyMaterial(intval($request->input('study_material_id', 0)));

        if(!$response['success']) {
            return $this->sendError('Возникли ошибки.', $response['data'], 422);
        }

        return $this->sendResponse($response['data'], $response['message']);
    }

    /**
     * @param StudyMaterialLogicInterface $studyMaterialLogic
     * @param Request $request
     * @return JsonResponse
     */
    public function destroy(StudyMaterialLogicInterface $studyMaterialLogic, Request $request) : JsonResponse
    {
        $response = $studyMaterialLogic->deleteStudyMaterial(intval($request->input('study_material_id', 0)));

        if(!$response['success']) {
            return $this->sendError('Возникли ошибки.', $response['data'], 422);
        }

        return $this->sendResponse($response['data'], $response['message']);
    }

    /**
     * @param StudyMaterialLogicInterface $studyMaterialLogic
     * @param StudyMaterialCreateRequest $request
     * @return JsonResponse
     */
    public function store(StudyMaterialLogicInterface $studyMaterialLogic, StudyMaterialCreateRequest $request) : JsonResponse
    {
        if(!empty($request->errors)) {
            return $this->sendError('Ошибка валидации данных.', $request->errors, 422);
        }

        $response = $studyMaterialLogic->createStudyMaterial($request->all());

        if(!$response['success']) {
            return $this->sendError('Возникли ошибки.', $response['data'], 422);
        }

        return $this->sendResponse($response['data'], $response['message']);
    }

    /**
     * @param StudyMaterialLogicInterface $studyMaterialLogic
     * @param StudyMaterialUpdateRequest $request
     * @return JsonResponse
     */
    public function update(StudyMaterialLogicInterface $studyMaterialLogic, StudyMaterialUpdateRequest $request) : JsonResponse
    {
        if(!empty($request->errors)) {
            return $this->sendError('Ошибка валидации данных.', $request->errors, 422);
        }

        $response = $studyMaterialLogic->updateStudyMaterial($request->all());

        if(!$response['success']) {
            return $this->sendError('Возникли ошибки.', $response['data'], 422);
        }

        return $this->sendResponse($response['data'], $response['message']);
    }
}
