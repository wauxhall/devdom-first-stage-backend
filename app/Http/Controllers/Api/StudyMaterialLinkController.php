<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Http\Requests\StudyMaterialLinkCreateRequest;
use App\Http\Requests\StudyMaterialLinkDeleteRequest;
use App\Http\Requests\StudyMaterialLinkUpdateRequest;
use App\Services\Contracts\StudyMaterialLinkLogicInterface;
use App\Traits\SendResponse;
use Illuminate\Http\JsonResponse;

class StudyMaterialLinkController extends Controller
{
    use SendResponse;

    /**
     * @param StudyMaterialLinkLogicInterface $studyMaterialLinkLogic
     * @param StudyMaterialLinkCreateRequest $request
     * @return JsonResponse
     */
    public function store(StudyMaterialLinkLogicInterface $studyMaterialLinkLogic, StudyMaterialLinkCreateRequest $request) : JsonResponse
    {
        if(!empty($request->errors)) {
            return $this->sendError('Ошибка валидации данных.', $request->errors, 422);
        }

        $response = $studyMaterialLinkLogic->createStudyMaterialLinks($request->input('study_material'), $request->input('links'));

        return $this->sendResponse($response, 'Ссылки добавлены!');
    }

    /**
     * @param StudyMaterialLinkLogicInterface $studyMaterialLinkLogic
     * @param StudyMaterialLinkUpdateRequest $request
     * @return JsonResponse
     */
    public function update(StudyMaterialLinkLogicInterface $studyMaterialLinkLogic, StudyMaterialLinkUpdateRequest $request) : JsonResponse
    {
        if(!empty($request->errors)) {
            return $this->sendError('Ошибка валидации данных.', $request->errors, 422);
        }

        $response = $studyMaterialLinkLogic->updateStudyMaterialLinks($request->input('study_material'), $request->input('links'));

        return $this->sendResponse($response, 'Ссылки обновлены!');
    }

    /**
     * @param StudyMaterialLinkLogicInterface $studyMaterialLinkLogic
     * @param StudyMaterialLinkDeleteRequest $request
     * @return JsonResponse
     */
    public function destroy(StudyMaterialLinkLogicInterface $studyMaterialLinkLogic, StudyMaterialLinkDeleteRequest $request) : JsonResponse
    {
        if(!empty($request->errors)) {
            return $this->sendError('Ошибка валидации данных.', $request->errors, 422);
        }

        $response = $studyMaterialLinkLogic->deleteStudyMaterialLinks($request->input('study_material'), $request->input('link_ids'));

        return $this->sendResponse($response, 'Ссылки удалены!');
    }
}
