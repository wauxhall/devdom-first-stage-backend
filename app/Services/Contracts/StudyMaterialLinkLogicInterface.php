<?php

namespace App\Services\Contracts;

Interface StudyMaterialLinkLogicInterface
{
    public function createStudyMaterialLinks(array $links) : array;
    public function updateStudyMaterialLinks(array $links) : array;
    public function deleteStudyMaterialLinks(array $links) : array;
}
