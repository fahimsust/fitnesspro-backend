<?php

namespace App\Api\Admin\Sites\Controllers;

use App\Api\Admin\Sites\Requests\UpdateSectionModuleTemplateRequest;
use Domain\Sites\Models\Site;
use Support\Controllers\AbstractController;
use Symfony\Component\HttpFoundation\Response;

class UpdateSectionModuleTemplateController extends AbstractController
{
    /**
     * Handle the incoming request.
     *
     * @param  \Illuminate\Http\Request  $request
     *
     * @return \Illuminate\Http\Response
     */
    public function store(Site $site, UpdateSectionModuleTemplateRequest $request)
    {
        $site->settings()->update(
            [
                $request->field_name => $request->module_template_id,
            ]
        );
        return response(
            $site->settings,
            Response::HTTP_CREATED
        );
    }
}
