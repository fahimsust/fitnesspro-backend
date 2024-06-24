<?php

namespace App\Api\Support\Controllers;

use Domain\Sites\Actions\Currencies\CurrencyForSite;
use Support\Controllers\AbstractController;
use Symfony\Component\HttpFoundation\Response;

class CurrencyController extends AbstractController
{
    /**
     * Handle the incoming request.s
     *
     * @param \Illuminate\Http\Request $request
     *
     * @return \Illuminate\Http\Response
     */
    public function __invoke(int $site_id)
    {
        return response(
            CurrencyForSite::run($site_id),
            Response::HTTP_OK
        );
    }
}
