<?php
namespace App\Api\Admin\Discounts\Controllers;

use App\Api\Admin\Discounts\Requests\ConditionMemberShipRequest;
use Domain\Discounts\Models\Rule\Condition\ConditionCountry;
use Domain\Discounts\Models\Rule\Condition\ConditionMembershipLevel;
use Support\Controllers\AbstractController;
use Symfony\Component\HttpFoundation\Response;

class ConditionMemberShipController extends AbstractController
{
    public function store(ConditionMemberShipRequest $request)
    {
        return response(
            ConditionMembershipLevel::create(
                [
                    'condition_id'=>$request->condition_id,
                    'membershiplevel_id'=>$request->membershiplevel_id,
                ]
            ),
            Response::HTTP_CREATED
        );
    }
    public function destroy(ConditionMembershipLevel $conditionMembership)
    {
        return response(
            $conditionMembership->delete(),
            Response::HTTP_OK
        );
    }
}
