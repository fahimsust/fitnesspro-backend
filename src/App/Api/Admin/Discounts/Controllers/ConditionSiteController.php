<?php
namespace App\Api\Admin\Discounts\Controllers;

use App\Api\Admin\Discounts\Requests\ConditionSiteRequest;
use Domain\Discounts\Models\Rule\Condition\ConditionSite;
use Support\Controllers\AbstractController;
use Symfony\Component\HttpFoundation\Response;

class ConditionSiteController extends AbstractController
{
    public function store(ConditionSiteRequest $request)
    {
        return response(
            ConditionSite::create(
                [
                    'condition_id'=>$request->condition_id,
                    'site_id'=>$request->site_id,
                ]
            ),
            Response::HTTP_CREATED
        );
    }
    public function destroy(ConditionSite $conditionSite)
    {
        return response(
            $conditionSite->delete(),
            Response::HTTP_OK
        );
    }
}
