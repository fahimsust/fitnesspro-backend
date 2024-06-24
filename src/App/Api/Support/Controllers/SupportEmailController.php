<?php

namespace App\Api\Support\Controllers;

use App\Api\Support\Requests\SupportEmailRequest;
use Domain\Sites\Models\Site;
use Domain\Support\Actions\Mail\SendSupportEmail;
use Domain\Support\Models\SupportDepartment;
use Support\Controllers\AbstractController;
use Symfony\Component\HttpFoundation\Response;

class SupportEmailController extends AbstractController
{
    public function index()
    {
        return response(
            SupportDepartment::all()
        );
    }

    public function send(SupportEmailRequest $request)
    {
        return response(
            SendSupportEmail::run(
                $request,
                Site::findOrFail(config('site.id'))
            ),
            Response::HTTP_CREATED
        );
    }
}
