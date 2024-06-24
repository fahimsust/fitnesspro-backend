<?php

namespace App\Api\Admin\Discounts\Controllers;

use App\Api\Admin\Discounts\Requests\ConditionModelUpdateRequest;
use App\Api\Admin\Discounts\Requests\ConditionOutOfStockStatusRequest;
use Domain\Discounts\Models\Rule\Condition\ConditionOutOfStockStatus;
use Support\Controllers\AbstractController;
use Symfony\Component\HttpFoundation\Response;

class ConditionOutOfStockStatusController extends AbstractController
{
    public function store(ConditionOutOfStockStatusRequest $request)
    {
        return response(
            ConditionOutOfStockStatus::create(
                [
                    'outofstockstatus_id' => $request->outofstockstatus_id,
                    'condition_id' => $request->condition_id,
                ]
            ),
            Response::HTTP_CREATED
        );
    }
    public function update(ConditionOutOfStockStatus $conditionOutOfStockStatus, ConditionModelUpdateRequest $request)
    {
        return response(
            $conditionOutOfStockStatus->update([
                'required_qty' => $request->required_qty
            ]),
            Response::HTTP_CREATED
        );
    }
    public function destroy(ConditionOutOfStockStatus $conditionOutOfStockStatus)
    {
        return response(
            $conditionOutOfStockStatus->delete(),
            Response::HTTP_OK
        );
    }
}
