<?php
namespace App\Api\Admin\Discounts\Controllers;

use App\Api\Admin\Discounts\Requests\DiscountRuleMatchRequest;
use Domain\Discounts\Models\Discount;
use Support\Controllers\AbstractController;
use Symfony\Component\HttpFoundation\Response;

class DiscountMatchRuleController extends AbstractController
{
    public function update(Discount $discountMatchRule, DiscountRuleMatchRequest $request)
    {
        $discountMatchRule->update([
            'match_anyall'=>$request->match_anyall,
        ]);
        return response(
            $discountMatchRule->refresh(),
            Response::HTTP_CREATED
        );
    }
}
