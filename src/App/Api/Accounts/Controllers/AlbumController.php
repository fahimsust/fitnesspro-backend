<?php

namespace App\Api\Accounts\Controllers;

use Domain\Accounts\Models\Account;
use Domain\Accounts\Models\AccountPhotoAlbum;
use Support\Controllers\AbstractController;

class AlbumController extends AbstractController
{
    public function index(Account $account)
    {
        return [
            'albums' => AccountPhotoAlbum::for($account)->paginate(),
        ];
    }
}
