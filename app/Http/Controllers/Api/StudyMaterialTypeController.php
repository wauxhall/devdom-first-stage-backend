<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\StudyMaterialType;
use App\Traits\SendResponse;
use Illuminate\Http\JsonResponse;

class StudyMaterialTypeController extends Controller
{
    use SendResponse;

    /**
     * Display a listing of the resource.
     *
     * @return JsonResponse
     */
    public function index() : JsonResponse
    {
        return $this->sendResponse(StudyMaterialType::all()->toArray(), '');
    }
}
