<?php

namespace Domain\Photos\Actions;

use Domain\Photos\Models\Photo;
use Domain\Photos\Models\PhotoAlbum;

class RemovePhotoFromAlbum
{
    public function __invoke(
        Photo $photo,
        PhotoAlbum $album
    ): PhotoAlbum {
        $album->decrement('photos_count', 1, [
            'recent_photo_id' => $album->photos()
                ->latest('added')
                ->first(),
        ]);

        return $album;
    }
}
