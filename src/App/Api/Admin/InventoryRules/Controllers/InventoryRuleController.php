<?php

namespace App\Api\Admin\InventoryRules\Controllers;

use Domain\Sites\Models\InventoryRule;
use Illuminate\Http\Request;
use Support\Controllers\AbstractController;
use Symfony\Component\HttpFoundation\Response;

class InventoryRuleController extends AbstractController
{
    public function index(Request $request)
    {
        return Response
        (
            InventoryRule::search($request)->get(),
            Response::HTTP_OK
        );
    }
}
