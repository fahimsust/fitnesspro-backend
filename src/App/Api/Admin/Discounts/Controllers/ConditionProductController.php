<?php
namespace App\Api\Admin\Discounts\Controllers;

use App\Api\Admin\Discounts\Requests\ConditionModelUpdateRequest;
use App\Api\Admin\Discounts\Requests\ConditionProductRequest;
use Domain\Discounts\Models\Rule\Condition\ConditionProduct;
use Support\Controllers\AbstractController;
use Symfony\Component\HttpFoundation\Response;

class ConditionProductController extends AbstractController
{
    public function store(ConditionProductRequest $request)
    {
        return response(
            ConditionProduct::create(
                [
                    'product_id'=>$request->product_id,
                    'condition_id'=>$request->condition_id,
                ]
            ),
            Response::HTTP_CREATED
        );
    }
    public function update(ConditionProduct $conditionProduct,ConditionModelUpdateRequest $request)
    {
        return response(
            $conditionProduct->update([
                'required_qty'=>$request->required_qty
            ]),
            Response::HTTP_CREATED
        );
    }
    public function destroy(ConditionProduct $conditionProduct)
    {
        return response(
            $conditionProduct->delete(),
            Response::HTTP_OK
        );
    }
}
