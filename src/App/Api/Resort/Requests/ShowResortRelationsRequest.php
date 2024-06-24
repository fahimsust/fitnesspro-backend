<?php

namespace App\Api\Resort\Requests;

class ShowResortRelationsRequest extends ResortRelationsRequest
{
    public function relations()
    {
        return array_merge(parent::relations(), [
            'specialties',
            'albums.photos',
            'images',
        ]);
    }
}
