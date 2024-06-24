<?php

namespace App\Api\Admin\Accounts\Controllers;

use Domain\Accounts\Models\AccountStatus;
use Support\Controllers\AbstractController;
use Symfony\Component\HttpFoundation\Response;

class AccountStatusController extends AbstractController
{
    public function index()
    {
        return response(
            AccountStatus::orderBy('name')->get(),
            Response::HTTP_OK
        );
    }
}
