<?php

namespace App\Api\Admin\Discounts\Controllers;

use App\Api\Admin\Discounts\Requests\DiscountRequest;
use App\Api\Admin\Discounts\Requests\DiscountSearchRequest;
use Domain\Discounts\Actions\Admin\CreateDiscount;
use Domain\Discounts\Actions\Admin\UpdateDiscount;
use Domain\Discounts\Models\Discount;
use Support\Controllers\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Illuminate\Http\Request;

class DiscountController extends AbstractController
{
    public function index(DiscountSearchRequest $request)
    {
        return response(
            Discount::query()
                ->search($request)
                ->when(
                    $request->filled('order_by'),
                    fn ($query) => $query->orderBy($request->order_by,$request->order_type?$request->order_type:'asc')
                )
                ->paginate($request?->per_page),
            Response::HTTP_OK
        );
    }
    public function store(DiscountRequest $request)
    {
        return response(
            CreateDiscount::run($request),
            Response::HTTP_CREATED
        );
    }
    public function update(Discount $discount, DiscountRequest $request)
    {
        return response(
            UpdateDiscount::run($discount, $request),
            Response::HTTP_CREATED
        );
    }

    public function show(Discount $discount)
    {
        return response(
            $discount,
            Response::HTTP_OK
        );
    }

    public function destroy(Discount $discount)
    {
        return response(
            $discount->delete(),
            Response::HTTP_OK
        );
    }
}
