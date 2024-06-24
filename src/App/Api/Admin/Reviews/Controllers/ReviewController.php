<?php

namespace App\Api\Admin\Reviews\Controllers;

use App\Api\Admin\Reviews\Requests\ReviewRequest;
use Domain\Products\Models\Attribute\AttributeOption;
use Domain\Products\Models\Product\Product;
use Domain\Products\Models\Product\ProductReview;
use Illuminate\Http\Request;
use Support\Controllers\AbstractController;
use Symfony\Component\HttpFoundation\Response;

class ReviewController extends AbstractController
{
    public function index(Request $request)
    {
        return response(
            ProductReview::search($request)
            ->with('item')
            ->where(function($query){
                $query->whereHasMorph('item',Product::class)
                ->orWhereHasMorph('item',AttributeOption::class);
            })
            ->when(
                $request->filled('order_by'),
                fn ($query) => $query->orderBy($request->order_by,$request->order_type?$request->order_type:'asc'),
                fn ($query) => $query->orderBy('created','DESC')
            )
            ->paginate($request?->per_page),
            Response::HTTP_OK
        );
    }

    public function update(ProductReview $productReview, ReviewRequest $request)
    {
        return response(
            $productReview->update([
                'name' => $request->name,
                'comment' => $request->comment,
                'rating' => $request->rating,
            ]),
            Response::HTTP_CREATED
        );
    }

    public function show(int $review_id)
    {
        return response(
            ProductReview::whereId($review_id)->with('item')->first(),
            Response::HTTP_OK
        );
    }

    public function destroy(ProductReview $productReview)
    {
        return response(
            $productReview->delete(),
            Response::HTTP_OK
        );
    }
}
