<?php

namespace App\Api\Admin\PricingRules\Controllers;

use Domain\Products\Models\Product\Pricing\PricingRule;
use Support\Controllers\AbstractController;
use Symfony\Component\HttpFoundation\Response;

class PricingRuleController extends AbstractController
{
    public function index()
    {
        return response(
            PricingRule::all(),
            Response::HTTP_OK
        );
    }
}
