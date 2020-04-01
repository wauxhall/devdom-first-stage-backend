<?php

namespace App\Services;

use App\Models\StudyMaterialLink;
use App\Services\Contracts\StudyMaterialLinkLogicInterface;

class StudyMaterialLinkService implements StudyMaterialLinkLogicInterface
{
    /**
     * @param array $links
     * @return array
     */
    public function createStudyMaterialLinks(array $links) : array
    {
        $response = [];

        foreach($links as $link) {
            $new_link = StudyMaterialLink::create($link);

            $response[] = [
                'id' => $new_link->id,
                'study_material_id' => $link['study_material_id'],
                'link' => $link['link']
            ];
        }

        return $response;
    }

    /**
     * @param array $links
     * @return array
     */
    public function updateStudyMaterialLinks(array $links) : array
    {
        foreach($links as $link) {
            StudyMaterialLink::where('id', $link['id'])->update([ 'link' => $link['link'] ]);
        }

        return $links;
    }

    /**
     * Delete only one link related to study material. Return rows affected.
     *
     * @param array $links
     * @return array
     */
    public function deleteStudyMaterialLinks(array $links) : array
    {
        StudyMaterialLink::whereIn('id', $links)->delete();

        return $links;
    }
}
