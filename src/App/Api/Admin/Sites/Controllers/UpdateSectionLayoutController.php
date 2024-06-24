<?php

namespace App\Api\Admin\Sites\Controllers;

use App\Api\Admin\Sites\Requests\UpdateSectionLayoutRequest;
use Domain\Sites\Models\Site;
use Support\Controllers\AbstractController;
use Symfony\Component\HttpFoundation\Response;

class UpdateSectionLayoutController extends AbstractController
{
    /**
     * Handle the incoming request.
     *
     * @param  \Illuminate\Http\Request  $request
     *
     * @return \Illuminate\Http\Response
     */
    public function store(Site $site, UpdateSectionLayoutRequest $request)
    {
        $site->settings()->update(
            [
                $request->field_name => $request->layout_id,
            ]
        );
        return response(
            $site->settings,
            Response::HTTP_CREATED
        );
    }
}
