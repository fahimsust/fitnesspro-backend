<?php

namespace App\Api\Admin\MemberShipLevels\Controllers;

use Domain\Accounts\Models\Membership\MembershipLevel;
use Illuminate\Http\Request;
use Support\Controllers\AbstractController;
use Symfony\Component\HttpFoundation\Response;

class MemberShipLevelsController extends AbstractController
{
    public function index()
    {
        return response(
            MembershipLevel::with('product', 'product.pricingForCurrentSite')->get(),
            Response::HTTP_OK
        );
    }
}
