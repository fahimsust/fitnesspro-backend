<?php
namespace App\Api\Admin\Discounts\Controllers;

use App\Api\Admin\Discounts\Requests\AdvantageModelUpdateRequest;
use App\Api\Admin\Discounts\Requests\AdvantageProductTypeRequest;
use Domain\Discounts\Models\Advantage\AdvantageProductType;
use Support\Controllers\AbstractController;
use Symfony\Component\HttpFoundation\Response;

class AdvantageProductTypeController extends AbstractController
{
    public function store(AdvantageProductTypeRequest $request)
    {
        return response(
            AdvantageProductType::create(
                [
                    'producttype_id'=>$request->producttype_id,
                    'advantage_id'=>$request->advantage_id,
                ]
            ),
            Response::HTTP_CREATED
        );
    }
    public function update(AdvantageProductType $advantageProductType,AdvantageModelUpdateRequest $request)
    {
        return response(
            $advantageProductType->update([
                'applyto_qty'=>$request->applyto_qty
            ]),
            Response::HTTP_CREATED
        );
    }
    public function destroy(AdvantageProductType $advantageProductType)
    {
        return response(
            $advantageProductType->delete(),
            Response::HTTP_OK
        );
    }
}
