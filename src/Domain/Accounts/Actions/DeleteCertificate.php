<?php

namespace Domain\Accounts\Actions;


use Domain\Accounts\Models\Certifications\Certification;
use Lorisleiva\Actions\Concerns\AsObject;
use Illuminate\Support\Facades\Storage;

class DeleteCertificate
{
    use AsObject;

    public function handle(Certification $certification)
    {
        if ($certification->file_name) {
            Storage::disk('s3')->delete($certification->file_name);
        }

        // Delete the certification record
        return $certification->delete();
    }
}
