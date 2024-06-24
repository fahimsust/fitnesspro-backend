<?php
namespace App\Api\Admin\Discounts\Controllers;

use App\Api\Admin\Discounts\Requests\ConditionAvailabilityRequest;
use App\Api\Admin\Discounts\Requests\ConditionModelUpdateRequest;
use Domain\Discounts\Models\Rule\Condition\ConditionProductAvailability;
use Support\Controllers\AbstractController;
use Symfony\Component\HttpFoundation\Response;

class ConditionAvailabilityController extends AbstractController
{
    public function store(ConditionAvailabilityRequest $request)
    {
        return response(
            ConditionProductAvailability::create(
                [
                    'availability_id'=>$request->availability_id,
                    'condition_id'=>$request->condition_id,
                ]
            ),
            Response::HTTP_CREATED
        );
    }
    public function update(ConditionProductAvailability $conditionAvailability,ConditionModelUpdateRequest $request)
    {
        return response(
            $conditionAvailability->update([
                'required_qty'=>$request->required_qty
            ]),
            Response::HTTP_CREATED
        );
    }
    public function destroy(ConditionProductAvailability $conditionAvailability)
    {
        return response(
            $conditionAvailability->delete(),
            Response::HTTP_OK
        );
    }
}
