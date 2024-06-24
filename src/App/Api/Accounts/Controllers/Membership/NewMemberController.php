<?php

namespace App\Api\Accounts\Controllers\Membership;

use App\Api\Accounts\Requests\Membership\NewMemberRequest;
use Support\Controllers\AbstractController;

class NewMemberController extends AbstractController
{
    public function __invoke(NewMemberRequest $request)
    {
        // return response(
        //     CreateAccountFromNewMemberData::run(
        //         RegisteringMemberData::fromRequest($request),
        //         AddressData::fromRequest($request)
        //     ),
        //     Response::HTTP_CREATED
        // );
    }
}
