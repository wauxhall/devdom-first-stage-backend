<?php

namespace App\Services;

use App\Models\StudyMaterialLink;
use App\Services\Contracts\StudyMaterialLinkLogicInterface;

class StudyMaterialLinkService implements StudyMaterialLinkLogicInterface
{
    /**
     * @param int $sm_id
     * @param array $links
     * @return array
     */
    public function createStudyMaterialLinks(int $sm_id, array $links) : array
    {
        $create_data = [];

        foreach($links as $link) {
            $create_data[] = [
                'study_material_id' => $sm_id,
                'link' => $link
            ];
        }

        StudyMaterialLink::insert($create_data);

        return [
            'id' => $sm_id,
            'links' => $links
        ];
    }

    /**
     * @param int $sm_id
     * @param array $links
     * @return array
     */
    public function updateStudyMaterialLinks(int $sm_id, array $links) : array
    {
        foreach($links as $link) {
            StudyMaterialLink::where('study_material_id', $sm_id)->where('id', $link['id'])->update('link', $link['link']);
        }

        return [
            'id' => $sm_id,
            'links' => $links
        ];
    }

    /**
     * Delete only one link related to study material. Return rows affected.
     *
     * @param int $sm_id
     * @param array $link_ids
     * @return array
     */
    public function deleteStudyMaterialLinks(int $sm_id, array $link_ids) : array
    {
        StudyMaterialLink::where('study_material_id', $sm_id)->whereIn('id', $link_ids)->delete();

        return [
            'id' => $sm_id,
            'link_ids' => $link_ids
        ];
    }
}
