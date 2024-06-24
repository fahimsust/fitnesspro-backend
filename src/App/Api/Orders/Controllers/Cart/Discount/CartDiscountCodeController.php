<?php

namespace App\Api\Orders\Controllers\Cart\Discount;

use App\Api\Discounts\Requests\ApplyDiscountCodeRequest;
use App\Api\Orders\Resources\Cart\CartDiscountCodeResource;
use App\Api\Orders\Resources\Cart\CartResource;
use Domain\Orders\Actions\Cart\Discounts\ApplyDiscountCodeToCart;
use Domain\Orders\Actions\Cart\Discounts\RemoveDiscountFromCart;
use Domain\Orders\Enums\Cart\CartRelations;
use Domain\Orders\Models\Carts\CartDiscounts\CartDiscountCode;
use Support\Controllers\AbstractController;
use Symfony\Component\HttpFoundation\Response;

class CartDiscountCodeController extends AbstractController
{
    public function index()
    {
        return response([
            'discounts' => cart()->discountCodes()
                ->with('discount')
                ->get()
                ->map(
                    fn (CartDiscountCode $cartDiscountCode) => new CartDiscountCodeResource(
                        $cartDiscountCode
                    )
                ),
        ]);
    }

    public function store(ApplyDiscountCodeRequest $request)
    {
        $appliedDiscountCode = ApplyDiscountCodeToCart::run(
            $request->discount_code,
            $cart = cart(),
            user()
        );

        return response(
            [
                'cart' => new CartResource(
                    $cart->load(CartRelations::standard())
                ),
                'discount' => new CartDiscountCodeResource(
                    $appliedDiscountCode
                ),
            ],
            Response::HTTP_CREATED
        );
    }

    public function destroy(int $cartDiscountId)
    {
        return response(
            [
                'cart' => new CartResource(
                    RemoveDiscountFromCart::now(
                        cart(),
                        $cartDiscountId
                    )
                        ->load(CartRelations::standard())
                ),
            ],
            Response::HTTP_OK
        );
    }
}
