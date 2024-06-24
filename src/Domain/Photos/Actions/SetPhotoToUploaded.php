<?php

namespace Domain\Photos\Actions;

use Domain\Photos\Models\Photo;

class SetPhotoToUploaded
{
    public function __invoke(
        Photo $photo,
        string $filename
    ) {
        $photo->update(['approved' => true, 'img' => $filename]);

        return $photo;
    }
}
