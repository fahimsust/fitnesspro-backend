<?php

namespace App\Api\Admin\Affiliates\Controllers;

use Domain\Affiliates\Models\Affiliate;
use Support\Controllers\AbstractController;
use Symfony\Component\HttpFoundation\Response;

class AffiliateRestoreController extends AbstractController
{
    public function __invoke(Affiliate $affiliate)
    {
        return response(
            $affiliate->update(['status' => true]),
            Response::HTTP_OK
        );
    }
}
