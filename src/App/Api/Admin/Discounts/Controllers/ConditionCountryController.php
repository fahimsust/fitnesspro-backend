<?php
namespace App\Api\Admin\Discounts\Controllers;

use App\Api\Admin\Discounts\Requests\ConditionCountryRequest;
use Domain\Discounts\Models\Rule\Condition\ConditionCountry;
use Support\Controllers\AbstractController;
use Symfony\Component\HttpFoundation\Response;

class ConditionCountryController extends AbstractController
{
    public function store(ConditionCountryRequest $request)
    {
        return response(
            ConditionCountry::create(
                [
                    'condition_id'=>$request->condition_id,
                    'country_id'=>$request->country_id,
                ]
            ),
            Response::HTTP_CREATED
        );
    }
    public function destroy(ConditionCountry $conditionCountry)
    {
        return response(
            $conditionCountry->delete(),
            Response::HTTP_OK
        );
    }
}
