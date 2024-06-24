<?php

namespace App\Api\Accounts\Controllers\Registration;

use App\Api\Accounts\Requests\Registration\ApplyDiscountCodeToRegistrationRequest;
use App\Api\Accounts\Requests\Registration\RemoveDiscountFromRegistrationRequest;
use Domain\Orders\Actions\Cart\Discounts\ApplyDiscountCodeToCart;
use Domain\Orders\Actions\Cart\Discounts\RemoveDiscountFromCart;
use Domain\Orders\Actions\Cart\LoadCartByRegistrationId;
use Support\Controllers\AbstractController;
use Symfony\Component\HttpFoundation\Response;

class RegistrationDiscountController extends AbstractController
{
    public function index()
    {
        return response(
            LoadCartByRegistrationId::now(
                session('registrationId')
            )
                ->loadMissing([
                    'cartDiscounts.discount',
                    'cartDiscounts.advantages'
                ])
                ->cartDiscounts
        );
    }

    public function store(ApplyDiscountCodeToRegistrationRequest $request)
    {
        return response(
            ApplyDiscountCodeToCart::run(
                $request->discount_code,
                LoadCartByRegistrationId::now(
                    session('registrationId')
                )
            ),
            Response::HTTP_CREATED
        );
    }

    public function delete(RemoveDiscountFromRegistrationRequest $request)
    {
        return response(
            (new RemoveDiscountFromCart(
                LoadCartByRegistrationId::now(
                    session('registrationId')
                ),
                $request->registration_discount_id,
            ))
                ->execute()
                ->result()
                ->cartDiscounts,
            Response::HTTP_NO_CONTENT,
        );
    }
}
