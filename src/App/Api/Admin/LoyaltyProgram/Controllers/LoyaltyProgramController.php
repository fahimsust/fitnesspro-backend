<?php

namespace App\Api\Admin\LoyaltyProgram\Controllers;

use Domain\Accounts\Models\LoyaltyPoints\LoyaltyProgram;
use Support\Controllers\AbstractController;
use Symfony\Component\HttpFoundation\Response;

class LoyaltyProgramController extends AbstractController
{
    public function index()
    {
        return Response
        (
            LoyaltyProgram::all(),
            Response::HTTP_OK
        );
    }
}
