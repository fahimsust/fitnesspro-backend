<?php

namespace App\Api\Admin\Reviews\Controllers;

use App\Api\Admin\Reviews\Requests\ReviewApprovalRequest;
use Domain\Products\Models\Product\ProductReview;
use Support\Controllers\AbstractController;
use Symfony\Component\HttpFoundation\Response;

class ReviewApprovalController extends AbstractController
{
    public function __invoke(ProductReview $productReview, ReviewApprovalRequest $request)
    {
        $productReview->update([
            'approved' => $request->approved,
        ]);

        return response(
            $productReview,
            Response::HTTP_CREATED
        );
    }
}
