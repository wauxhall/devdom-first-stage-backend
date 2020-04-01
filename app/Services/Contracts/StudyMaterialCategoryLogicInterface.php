<?php

namespace App\Services\Contracts;

Interface StudyMaterialCategoryLogicInterface
{
    public function getCategories(array $filter_data = []) : array;
    public function getCategory(int $id) : array;
    public function getCategoryWithStudyMaterials(int $id) : array;
    public function createCategory(array $data) : array;
    public function updateCategory(int $id, array $data) : array;
    public function deleteCategory(int $id) : array;
}
