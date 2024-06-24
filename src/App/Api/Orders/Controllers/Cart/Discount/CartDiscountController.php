<?php

namespace App\Api\Orders\Controllers\Cart\Discount;

use App\Api\Orders\Resources\Cart\CartResource;
use Domain\Orders\Actions\Cart\Discounts\RemoveDiscountFromCart;
use Support\Controllers\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use function response;

class CartDiscountController extends AbstractController
{
    public function index()
    {
        return response(
            [
            'discounts' => cart()
                ->cartDiscounts()
                ->with(['discount', 'advantages', 'codes'])
                ->get(),
        ]
        );
    }

    public function destroy(int $cartDiscountId)
    {
        return response(
            [
                'cart' => (new CartResource(
                    RemoveDiscountFromCart::now(
                        \cart(),
                        $cartDiscountId
                    )
                ))
                    ->toArray(request()),
            ],
            Response::HTTP_OK
        );
    }
}
