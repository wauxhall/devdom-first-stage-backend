<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Http\Requests\StudyMaterialCreateRequest;
use App\Http\Requests\StudyMaterialFilterRequest;
use App\Http\Requests\StudyMaterialUpdateRequest;
use App\Services\Contracts\StudyMaterialLogicInterface;
use App\Traits\SendResponse;
use Illuminate\Http\JsonResponse;

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
     * @param $id
     * @param StudyMaterialLogicInterface $studyMaterialLogic
     * @return JsonResponse
     */
    public function show($id, StudyMaterialLogicInterface $studyMaterialLogic) : JsonResponse
    {
        $response = $studyMaterialLogic->getStudyMaterial(\intval($id));

        if(!$response['success']) {
            return $this->sendError('Возникли ошибки.', $response['data'], 422);
        }

        return $this->sendResponse($response['data'], $response['message']);
    }

    /**
     * @param $id
     * @param StudyMaterialLogicInterface $studyMaterialLogic
     * @return JsonResponse
     */
    public function destroy($id, StudyMaterialLogicInterface $studyMaterialLogic) : JsonResponse
    {
        $response = $studyMaterialLogic->deleteStudyMaterial(\intval($id));

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
     * @param $id
     * @param StudyMaterialLogicInterface $studyMaterialLogic
     * @param StudyMaterialUpdateRequest $request
     * @return JsonResponse
     */
    public function update($id, StudyMaterialLogicInterface $studyMaterialLogic, StudyMaterialUpdateRequest $request) : JsonResponse
    {
        if(!empty($request->errors)) {
            return $this->sendError('Ошибка валидации данных.', $request->errors, 422);
        }

        $response = $studyMaterialLogic->updateStudyMaterial(\intval($id), $request->all());

        if(!$response['success']) {
            return $this->sendError('Возникли ошибки.', $response['data'], 422);
        }

        return $this->sendResponse($response['data'], $response['message']);
    }
}
