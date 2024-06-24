<?php

namespace App\Api\Admin\Accounts\Controllers;

use App\Api\Admin\Accounts\Requests\AccountPhotoRequest;
use Domain\Accounts\Actions\DeletePhoto;
use Domain\Photos\Models\Photo;
use Illuminate\Http\Request;
use Support\Controllers\AbstractController;
use Symfony\Component\HttpFoundation\Response;

class AccountPhotoController extends AbstractController
{
    public function index(Request $request)
    {
        return response(
            Photo::orderBy('id', 'DESC')
                ->with('accountProfileImage')
                ->limit(100)
                ->where('addedby', $request->account_id)
                ->get(),
            Response::HTTP_OK
        );
    }
    public function update(Photo $accountPhoto, AccountPhotoRequest $request)
    {
        return response(
            $accountPhoto->update([
                'approved' => $request->approved,
            ]),
            Response::HTTP_CREATED
        );
    }
    public function destroy(Photo $accountPhoto)
    {
        return response(
            DeletePhoto::run($accountPhoto),
            Response::HTTP_OK
        );
    }
}
