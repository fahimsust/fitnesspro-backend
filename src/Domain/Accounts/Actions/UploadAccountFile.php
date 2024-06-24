<?php

namespace Domain\Accounts\Actions;

use App\Api\Admin\Accounts\Requests\AccountFileRequest;
use Domain\Accounts\Models\AccountFile;
use Lorisleiva\Actions\Concerns\AsObject;

class UploadAccountFile
{
    use AsObject;

    public function handle(AccountFileRequest $request): AccountFile
    {
        $filePath = null;

        if ($request->hasFile('filename')) {
            $file = $request->file('filename');
            $filePath = $file->store('account_files', 's3');
        }

        return AccountFile::create([
            'account_id' => $request->account_id,
            'approval_status' => true,
            'site_id' => config('site.id'),
            'uploaded' => now(),
            'filename' => $filePath,
        ]);
    }
}
