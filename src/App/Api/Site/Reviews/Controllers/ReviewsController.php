<?php

namespace App\Api\Site\Reviews\Controllers;

use App\Api\Site\Reviews\Requests\ReviewsRequest;
use Domain\Accounts\Actions\BuildCustomerReport;
use Domain\Products\Models\Product\ProductReview;
use stdClass;
use Support\Controllers\AbstractController;
use Symfony\Component\HttpFoundation\Response;

class ReviewsController extends AbstractController
{
    public function __invoke(ReviewsRequest $request)
    {

        return response(
            ProductReview::searchByProductOrOption($request)
                ->with('item')
                ->paginate($request?->per_page),
            Response::HTTP_OK
        );
    }
}
