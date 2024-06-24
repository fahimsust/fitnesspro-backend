<?php

namespace App\Api\Admin\Products\Controllers;

use Domain\Distributors\Models\Distributor;
use Illuminate\Http\Request;
use Support\Controllers\AbstractController;
use Symfony\Component\HttpFoundation\Response;

class DistributorsController extends AbstractController
{
    public function __invoke(Request $request)
    {
        return response(
            Distributor::where('active',1)
            ->search($request)
            ->orderBy('name')
            ->get(),
            Response::HTTP_OK
        );
    }
}
