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

    private $logic;

    /**
     * StudyMaterialLinkController constructor.
     * @param StudyMaterialLinkLogicInterface $studyMaterialLinkLogic
     */
    public function __construct(StudyMaterialLinkLogicInterface $studyMaterialLinkLogic)
    {
        $this->logic = $studyMaterialLinkLogic;
    }

    /**
     * @param StudyMaterialLinkCreateRequest $request
     * @return JsonResponse
     */
    public function create(StudyMaterialLinkCreateRequest $request) : JsonResponse
    {
        if(!empty($request->errors)) {
            return $this->sendError('Ошибка валидации данных.', $request->errors, 422);
        }

        $response = $this->logic->createStudyMaterialLinks($request->input('links'));

        return $this->sendResponse($response, 'Ссылки добавлены!');
    }

    /**
     * @param StudyMaterialLinkUpdateRequest $request
     * @return JsonResponse
     */
    public function update(StudyMaterialLinkUpdateRequest $request) : JsonResponse
    {
        if(!empty($request->errors)) {
            return $this->sendError('Ошибка валидации данных.', $request->errors, 422);
        }

        $response = $this->logic->updateStudyMaterialLinks($request->input('links'));

        return $this->sendResponse($response, 'Ссылки обновлены!');
    }

    /**
     * @param StudyMaterialLinkDeleteRequest $request
     * @return JsonResponse
     */
    public function destroy(StudyMaterialLinkDeleteRequest $request) : JsonResponse
    {
        if(!empty($request->errors)) {
            return $this->sendError('Ошибка валидации данных.', $request->errors, 422);
        }

        $response = $this->logic->deleteStudyMaterialLinks($request->input('links'));

        return $this->sendResponse($response, 'Ссылки удалены!');
    }
}
