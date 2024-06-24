<?php

namespace App\Api\Admin\Discounts\Controllers;

use Domain\Discounts\Enums\DiscountLevelApplyTo;
use Support\Controllers\AbstractController;
use Symfony\Component\HttpFoundation\Response;

class DiscountLevelApplyToController extends AbstractController
{
    /**
     * Handle the incoming request.
     *
     * @param \Illuminate\Http\Request $request
     *
     * @return \Illuminate\Http\Response
     */
    public function __invoke()
    {
        return response(
            collect(
                DiscountLevelApplyTo::cases()
            )
                ->map(
                    fn (DiscountLevelApplyTo $applyTo) => [
                        'id' => $applyTo->value,
                        'name' => $applyTo->label(),
                    ]
                ),
            Response::HTTP_OK
        );
    }
}
