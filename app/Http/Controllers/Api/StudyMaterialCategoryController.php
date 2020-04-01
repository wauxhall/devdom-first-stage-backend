<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Http\Requests\StudyMaterialCategoryCreateRequest;
use App\Http\Requests\StudyMaterialCategoryUpdateRequest;
use App\Services\Contracts\StudyMaterialCategoryLogicInterface;
use App\Traits\SendResponse;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;

class StudyMaterialCategoryController extends Controller
{
    use SendResponse;

    private $logic;

    public function __construct(StudyMaterialCategoryLogicInterface $studyMaterialCategoryLogic)
    {
        $this->logic = $studyMaterialCategoryLogic;
    }

    /**
     * Display a listing of the resource.
     *
     * @param Request $request
     * @return JsonResponse
     */
    public function index(Request $request) : JsonResponse
    {
        $response = $this->logic->getCategories($request->all());

        return $this->sendResponse($response, '');
    }

    /**
     * Display the specified resource.
     *
     * @param int $id
     * @return JsonResponse
     */
    public function show($id) : JsonResponse
    {
        $response = $this->logic->getCategoryWithStudyMaterials(\intval($id));

        if(!$response['success']) {
            return $this->sendError('Возникли ошибки.', $response['data'], 422);
        }

        return $this->sendResponse($response['data'], $response['message']);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param StudyMaterialCategoryCreateRequest $request
     * @return JsonResponse
     */
    public function create(StudyMaterialCategoryCreateRequest $request) : JsonResponse
    {
        if(!empty($request->errors)) {
            return $this->sendError('Ошибка валидации данных.', $request->errors, 422);
        }

        $response = $this->logic->createCategory($request->all());

        if(!$response['success']) {
            return $this->sendError('Возникли ошибки.', $response['data'], 422);
        }

        return $this->sendResponse($response['data'], $response['message']);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param StudyMaterialCategoryUpdateRequest $request
     * @param int $id
     * @return JsonResponse
     */
    public function update(StudyMaterialCategoryUpdateRequest $request, $id) : JsonResponse
    {
        if(!empty($request->errors)) {
            return $this->sendError('Ошибка валидации данных.', $request->errors, 422);
        }

        $response = $this->logic->updateCategory(\intval($id), $request->all());

        if(!$response['success']) {
            return $this->sendError('Возникли ошибки.', $response['data'], 422);
        }

        return $this->sendResponse($response['data'], $response['message']);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param int $id
     * @return JsonResponse
     */
    public function destroy($id) : JsonResponse
    {
        $response = $this->logic->deleteCategory(\intval($id));

        if(!$response['success']) {
            return $this->sendError('Возникли ошибки.', $response['data'], 422);
        }

        return $this->sendResponse($response['data'], $response['message']);
    }
}
