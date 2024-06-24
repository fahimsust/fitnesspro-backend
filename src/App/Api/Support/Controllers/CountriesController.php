<?php

namespace App\Api\Support\Controllers;

use Domain\Locales\Models\Country;
use Illuminate\Http\Request;
use Support\Controllers\AbstractController;
use Symfony\Component\HttpFoundation\Response;

class CountriesController extends AbstractController
{
    /**
     * Handle the incoming request.s
     *
     * @param \Illuminate\Http\Request $request
     *
     * @return \Illuminate\Http\Response
     */
    public function __invoke(Request $request)
    {
        return response(
            Country::select('id', 'name')->search($request)->get(),
            Response::HTTP_OK
        );
    }
}
