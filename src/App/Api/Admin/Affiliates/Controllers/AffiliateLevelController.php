<?php

namespace App\Api\Admin\Affiliates\Controllers;

use Domain\Affiliates\Models\AffiliateLevel;
use Support\Controllers\AbstractController;
use Symfony\Component\HttpFoundation\Response;

class AffiliateLevelController extends AbstractController
{
    public function index()
    {
        return response(
            AffiliateLevel::all(),
            Response::HTTP_OK
        );
    }
}
