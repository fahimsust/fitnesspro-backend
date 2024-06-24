<?php

namespace App\Api\Orders\Controllers\Checkout;

use App\Api\Orders\Requests\Checkout\GetCheckoutRequest;
use App\Api\Orders\Requests\Checkout\RecoverCheckoutRequest;
use App\Api\Orders\Requests\Checkout\SetCheckoutCommentsRequest;
use App\Api\Orders\Resources\Checkout\CheckoutResource;
use Domain\Orders\Actions\Checkout\SetCheckoutComments;
use Support\Controllers\AbstractController;

class CommentsController extends AbstractController
{
    public function __invoke(SetCheckoutCommentsRequest $request)
    {
        return [
            'checkout' => new CheckoutResource(
                SetCheckoutComments::now(
                    $request->loadCheckoutByUuid(),
                    $request->comments
                )
            )
        ];
    }
}
