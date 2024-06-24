<?php
namespace App\Api\Admin\Discounts\Controllers;

use App\Api\Admin\Discounts\Requests\ConditionDistributorRequest;
use Domain\Discounts\Models\Rule\Condition\ConditionDistributor;
use Support\Controllers\AbstractController;
use Symfony\Component\HttpFoundation\Response;

class ConditionDistributorController extends AbstractController
{
    public function store(ConditionDistributorRequest $request)
    {
        return response(
            ConditionDistributor::create(
                [
                    'distributor_id'=>$request->distributor_id,
                    'condition_id'=>$request->condition_id,
                ]
            ),
            Response::HTTP_CREATED
        );
    }
    public function destroy(ConditionDistributor $conditionDistributor)
    {
        return response(
            $conditionDistributor->delete(),
            Response::HTTP_OK
        );
    }
}
