<?php

namespace App\Services\Contracts;

Interface StudyMaterialLogicInterface
{
    public function getStudyMaterials(array $filter_data = []) : array;
    public function getStudyMaterial(int $id) : array;
    public function createStudyMaterial(array $data) : array;
    public function updateStudyMaterial(int $id, array $data) : array;
    public function deleteStudyMaterial(int $id) : array;
}
