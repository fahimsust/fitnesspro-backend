<?php

namespace App\Api\Accounts\Controllers\Registration;

use App\Api\Accounts\Requests\Registration\SetRegistrationMembershipLevelRequest;
use Domain\Accounts\Actions\Membership\Levels\GetAvailableLevels;
use Domain\Accounts\Actions\Membership\SetRegistrationMembershipLevel;
use Domain\Accounts\Actions\Registration\LoadRegistrationById;
use Domain\Accounts\Actions\Registration\Order\Cart\StartCartFromRegistration;
use Domain\Accounts\Models\Registration\Registration;
use Support\Controllers\AbstractController;
use Symfony\Component\HttpFoundation\Response;

class SelectMembershipLevelController extends AbstractController
{
    public function index()
    {
        return response()->json([
            'levels' => GetAvailableLevels::now(),
            'selected_level' => LoadRegistrationById::now(session('registrationId'))->level_id
        ]);
    }

    public function store(
        SetRegistrationMembershipLevelRequest $request
    )
    {
        return response(
            SetRegistrationMembershipLevel::now(
                $request->level_id,
                session('registrationId')
            ),
            Response::HTTP_CREATED
        );
    }

    public function show()
    {
        return response(
            Registration::findOrFail(session('registrationId'))->levelWithProductPricing
        );
    }
}
