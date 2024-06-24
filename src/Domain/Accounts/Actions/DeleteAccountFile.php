<?php

namespace Domain\Accounts\Actions;

use Domain\Accounts\Models\AccountFile;
use Domain\Accounts\Models\Certifications\Certification;
use Lorisleiva\Actions\Concerns\AsObject;
use Illuminate\Support\Facades\Storage;

class DeleteAccountFile
{
    use AsObject;

    public function handle(AccountFile $accountFile)
    {
        if ($accountFile->filename) {
            Storage::disk('s3')->delete($accountFile->filename);
        }

        // Delete the Account Files record
        return $accountFile->delete();
    }
}
