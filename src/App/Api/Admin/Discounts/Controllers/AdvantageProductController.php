<?php
namespace App\Api\Admin\Discounts\Controllers;

use App\Api\Admin\Discounts\Requests\AdvantageModelUpdateRequest;
use App\Api\Admin\Discounts\Requests\AdvantageProductRequest;
use Domain\Discounts\Models\Advantage\AdvantageProduct;
use Support\Controllers\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Illuminate\Http\Request;

class AdvantageProductController extends AbstractController
{
    public function store(AdvantageProductRequest $request)
    {
        return response(
            AdvantageProduct::create(
                [
                    'product_id'=>$request->product_id,
                    'advantage_id'=>$request->advantage_id,
                ]
            ),
            Response::HTTP_CREATED
        );
    }
    public function update(AdvantageProduct $advantageProduct,AdvantageModelUpdateRequest $request)
    {
        return response(
            $advantageProduct->update([
                'applyto_qty'=>$request->applyto_qty
            ]),
            Response::HTTP_CREATED
        );
    }
    public function destroy(AdvantageProduct $advantageProduct)
    {
        return response(
            $advantageProduct->delete(),
            Response::HTTP_OK
        );
    }
}
