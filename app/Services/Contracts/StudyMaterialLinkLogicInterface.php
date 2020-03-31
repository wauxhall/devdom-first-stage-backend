<?php

namespace App\Services\Contracts;

Interface StudyMaterialLinkLogicInterface
{
    public function createStudyMaterialLinks(int $id, array $links) : array;
    public function updateStudyMaterialLinks(int $id, array $links) : array;
    public function deleteStudyMaterialLinks(int $id, array $link_ids) : array;
}
