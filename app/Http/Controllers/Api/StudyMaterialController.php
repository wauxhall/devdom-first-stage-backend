<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Http\Requests\StudyMaterialFilterRequest;
use App\Models\StudyMaterial;
use App\Services\Contracts\StudyMaterialLogicInterface;
use Illuminate\Http\Request;

class StudyMaterialController extends Controller
{

    /**
     * @param StudyMaterialLogicInterface $studyMaterialLogic
     * @param StudyMaterialFilterRequest $request
     * @return array
     */
    public function index(StudyMaterialLogicInterface $studyMaterialLogic, StudyMaterialFilterRequest $request)
    {
        return $studyMaterialLogic->getStudyMaterials($request->all());
    }

    public function store(Request $request)
    {
        //
    }

    public function show(StudyMaterial $studyMaterial)
    {
        //
    }

    public function update(Request $request, StudyMaterial $studyMaterial)
    {
        //
    }

    public function destroy(StudyMaterial $studyMaterial)
    {
        //
    }
}
