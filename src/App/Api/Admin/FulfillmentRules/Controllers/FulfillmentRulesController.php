<?php

namespace App\Api\Admin\FulfillmentRules\Controllers;

use Domain\Products\Models\FulfillmentRules\FulfillmentRule;
use Support\Controllers\AbstractController;
use Symfony\Component\HttpFoundation\Response;

class FulfillmentRulesController extends AbstractController
{
    public function index()
    {
        return response(
            FulfillmentRule::where('status',1)->orderBy('name')->get(),
            Response::HTTP_OK
        );
    }
}
