<?php

namespace App\Api\Admin\Sites\Controllers;

use App\Api\Admin\Sites\Requests\AllowOrderingOfRequest;
use Domain\Sites\Models\Site;
use Support\Controllers\AbstractController;
use Symfony\Component\HttpFoundation\Response;

class AllowOrderingOfController extends AbstractController
{
    public function index(Site $site)
    {
        return response(
            $site->settings,
            Response::HTTP_OK
        );
    }
    /**
     * Handle the incoming request.
     *
     * @param  \Illuminate\Http\Request  $request
     *
     * @return \Illuminate\Http\Response
     */
    public function store(Site $site, AllowOrderingOfRequest $request)
    {
        $site->settings()->update(
            [
                'cart_allowavailability' => json_encode($request->cart_allowavailability),
                'cart_orderonlyavailableqty' => $request->cart_orderonlyavailableqty,
                'cart_addtoaction' => $request->cart_addtoaction,
            ]
        );
        return response(
            $site->settings,
            Response::HTTP_CREATED
        );
    }
}
