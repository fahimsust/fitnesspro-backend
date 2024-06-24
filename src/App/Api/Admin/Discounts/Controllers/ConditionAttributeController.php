<?php
namespace App\Api\Admin\Discounts\Controllers;

use App\Api\Admin\Discounts\Requests\ConditionAttributeRequest;
use App\Api\Admin\Discounts\Requests\ConditionModelUpdateRequest;
use Domain\Discounts\Models\Rule\Condition\ConditionAttribute;
use Support\Controllers\AbstractController;
use Symfony\Component\HttpFoundation\Response;

class ConditionAttributeController extends AbstractController
{
    public function store(ConditionAttributeRequest $request)
    {
        return response(
            ConditionAttribute::create(
                [
                    'attributevalue_id'=>$request->attributevalue_id,
                    'condition_id'=>$request->condition_id,
                ]
            ),
            Response::HTTP_CREATED
        );
    }
    public function update(ConditionAttribute $conditionAttribute,ConditionModelUpdateRequest $request)
    {
        return response(
            $conditionAttribute->update([
                'required_qty'=>$request->required_qty
            ]),
            Response::HTTP_CREATED
        );
    }
    public function destroy(ConditionAttribute $conditionAttribute,)
    {
        return response(
            $conditionAttribute->delete(),
            Response::HTTP_OK
        );
    }
}
