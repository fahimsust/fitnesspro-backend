<?php

namespace App\Api\Admin\Sites\Controllers;

use App\Api\Admin\Sites\Requests\DefaultAccountTypeRequest;
use Domain\Sites\Actions\SetRequireLoginForSite;
use Domain\Sites\Enums\RequireLogin;
use Domain\Sites\Models\Site;
use Support\Controllers\AbstractController;
use Symfony\Component\HttpFoundation\Response;

class DefaultAccountTypeController extends AbstractController
{
    public function __invoke(Site $site, DefaultAccountTypeRequest $request)
    {
        $site->update(
            [
                'account_type_id' => $request->account_type_id,
                'required_account_types' => $request->required_account_types
            ]
        );
        SetRequireLoginForSite::run(
            $site,
            RequireLogin::tryFrom($request->requireLogin)
        );
        return response(
            $site,
            Response::HTTP_CREATED
        );
    }
}
