<?php
namespace App\Api\Admin\Discounts\Controllers;

use App\Api\Admin\Discounts\Requests\ConditionAccountTypeRequest;
use Domain\Discounts\Models\Rule\Condition\ConditionAccountType;
use Support\Controllers\AbstractController;
use Symfony\Component\HttpFoundation\Response;

class ConditionAccountTypeController extends AbstractController
{
    public function store(ConditionAccountTypeRequest $request)
    {
        return response(
            ConditionAccountType::create(
                [
                    'condition_id'=>$request->condition_id,
                    'accounttype_id'=>$request->accounttype_id,
                ]
            ),
            Response::HTTP_CREATED
        );
    }
    public function destroy(ConditionAccountType $conditionAccountType)
    {
        return response(
            $conditionAccountType->delete(),
            Response::HTTP_OK
        );
    }
}
