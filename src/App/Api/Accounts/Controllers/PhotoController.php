<?php

namespace App\Api\Accounts\Controllers;

use App\Api\Accounts\Requests\AccountPhotoUploadRequest;
use Domain\Accounts\Actions\AccountPhotoUpload;
use Domain\Accounts\Models\Account;
use Support\Controllers\AbstractController;

class PhotoController extends AbstractController
{
    public function store(Account $account, AccountPhotoUploadRequest $request)
    {
        $uploaded = resolve(
            AccountPhotoUpload::class,
            [
                'account' => $account,
                'fileStream' => $request->file,
                'album' => $request->album,
            ]
        )->upload($request->title);

        return $uploaded->uploadedData();
    }
}
