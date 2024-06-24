<?php

namespace Domain\Accounts\Actions;

use Domain\Accounts\Models\AccountFile;
use Domain\Accounts\Models\Certifications\Certification;
use Domain\Photos\Models\Photo;
use Lorisleiva\Actions\Concerns\AsObject;
use Illuminate\Support\Facades\Storage;

class DeletePhoto
{
    use AsObject;

    public function handle(Photo $photo)
    {
        if ($photo->img) {
            Storage::disk('s3')->delete($photo->img);
        }

        // Delete the Account Files record
        return $photo->delete();
    }
}
