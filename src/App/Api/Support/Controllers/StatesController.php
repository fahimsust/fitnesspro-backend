<?php

namespace App\Api\Support\Controllers;

use Domain\Locales\Models\StateProvince;
use Support\Controllers\AbstractController;
use Symfony\Component\HttpFoundation\Response;

class StatesController extends AbstractController
{
    /**
     * Handle the incoming request.
     *
     * @param \Illuminate\Http\Request $request
     *
     * @return \Illuminate\Http\Response
     */
    public function __invoke($country_id)
    {
        return response(
            StateProvince::whereCountryId($country_id)->select('id', 'name')->get(),
            Response::HTTP_OK
        );
    }
}
