<?php

namespace App\Api\Site\Reviews\Controllers;

use App\Api\Site\Reviews\Requests\CreateReviewRequest;
use Domain\Products\Actions\Reviews\CreateReviewForEntity;
use Domain\Products\Models\Product\Product;
use Illuminate\Http\Request;
use Support\Controllers\AbstractController;
use Symfony\Component\HttpFoundation\Response;

class ProductReviewsController extends AbstractController
{
    public function list(Product $product, Request $request)
    {
        return response(
            $product->reviews()->paginate($request?->per_page),
            Response::HTTP_OK
        );
    }
    public function store(Product $product, CreateReviewRequest $request)
    {
        return response(
            CreateReviewForEntity::run($product, $request),
            Response::HTTP_CREATED
        );
    }
}
