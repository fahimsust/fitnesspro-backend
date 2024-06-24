<?php
namespace App\Api\Admin\Discounts\Controllers;

use App\Api\Admin\Discounts\Requests\ConditionModelUpdateRequest;
use App\Api\Admin\Discounts\Requests\ConditionProductTypeRequest;
use Domain\Discounts\Models\Rule\Condition\ConditionProductType;
use Support\Controllers\AbstractController;
use Symfony\Component\HttpFoundation\Response;

class ConditionProductTypeController extends AbstractController
{
    public function store(ConditionProductTypeRequest $request)
    {
        return response(
            ConditionProductType::create(
                [
                    'condition_id'=>$request->condition_id,
                    'producttype_id'=>$request->producttype_id,
                ]
            ),
            Response::HTTP_CREATED
        );
    }
    public function update(ConditionProductType $conditionProductType,ConditionModelUpdateRequest $request)
    {
        return response(
            $conditionProductType->update([
                'required_qty'=>$request->required_qty
            ]),
            Response::HTTP_CREATED
        );
    }
    public function destroy(ConditionProductType $conditionProductType)
    {
        return response(
            $conditionProductType->delete(),
            Response::HTTP_OK
        );
    }
}
