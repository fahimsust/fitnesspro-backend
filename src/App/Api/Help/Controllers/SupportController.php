<?php

namespace App\Api\Help\Controllers;

use Domain\Messaging\Mail\SupportContact;
use Domain\Messaging\Requests\SupportContactRequest;
use Domain\Sites\Models\Site;
use Illuminate\Http\Response;
use function response;
use Support\Controllers\AbstractController;

class SupportController extends AbstractController
{
    /**
     * Store a newly created resource in storage.
     *
     * @param  SupportContactRequest  $request
     *
     * @return \Illuminate\Http\Response
     */
    public function store(SupportContactRequest $request)
    {
        Site::SendMailable(new SupportContact($request));

        return response(['message' => __('Your message has been sent.')], Response::HTTP_CREATED);
    }
}
