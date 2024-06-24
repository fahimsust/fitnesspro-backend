<?php

namespace Domain\Photos\Actions;

use Domain\Photos\Models\Photo;
use Domain\Photos\Models\PhotoAlbum;

class AssignPhotoToAlbum
{
    public function __invoke(
        Photo $photo,
        PhotoAlbum $album
    ): PhotoAlbum {
        $album->increment('photos_count', 1, [
            'recent_photo_id' => $photo->id,
        ]);

        return $album;
    }
}
