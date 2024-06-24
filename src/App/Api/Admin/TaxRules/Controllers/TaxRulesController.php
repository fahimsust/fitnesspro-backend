<?php

namespace App\Api\Admin\TaxRules\Controllers;

use Domain\Tax\Models\TaxRule;
use Support\Controllers\AbstractController;
use Symfony\Component\HttpFoundation\Response;

class TaxRulesController extends AbstractController
{
    public function index()
    {
        return response(
            TaxRule::orderBy('name')->get(),
            Response::HTTP_OK
        );
    }
}
