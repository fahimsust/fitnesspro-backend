<?php
namespace App\Api\Admin\Discounts\Controllers;

use App\Api\Admin\Discounts\Requests\DiscountAdvantageRequest;
use App\Api\Admin\Discounts\Requests\DiscountAdvantageUpdateRequest;
use Domain\Discounts\Models\Advantage\DiscountAdvantage;
use Illuminate\Http\Request;
use Support\Controllers\AbstractController;
use Symfony\Component\HttpFoundation\Response;

class DiscountAdvantageController extends AbstractController
{
    public function index(Request $request)
    {
        return response(
            DiscountAdvantage::whereDiscountId($request->discount_id)
            ->with('targetProducts')
            ->with('targetProductTypes')
            ->get(),
            Response::HTTP_OK
        );
    }
    public function store(DiscountAdvantageRequest $request)
    {
        return response(
            DiscountAdvantage::create(
                [
                    'discount_id'=>$request->discount_id,
                    'advantage_type_id'=>$request->advantage_type_id,
                ]
            ),
            Response::HTTP_CREATED
        );
    }
    public function update(DiscountAdvantage $discountAdvantage, DiscountAdvantageUpdateRequest $request)
    {
        $data = $request->validated();
        return response(
            $discountAdvantage->update($data),
            Response::HTTP_CREATED
        );
    }
    public function show(int $advantage_id)
    {
        return response(
            DiscountAdvantage::whereId($advantage_id)
            ->with('targetProducts')
            ->with('targetProductTypes')
            ->first(),
            Response::HTTP_OK
        );
    }
    public function destroy(DiscountAdvantage $discountAdvantage)
    {
        return response(
            $discountAdvantage->delete(),
            Response::HTTP_OK
        );
    }
}
