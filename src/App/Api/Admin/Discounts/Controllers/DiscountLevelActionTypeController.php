<?php

namespace App\Api\Admin\Discounts\Controllers;

use Domain\Discounts\Enums\DiscountLevelActionType;
use Support\Controllers\AbstractController;
use Symfony\Component\HttpFoundation\Response;

class DiscountLevelActionTypeController extends AbstractController
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
                DiscountLevelActionType::cases()
            )
                ->map(
                    fn (DiscountLevelActionType $actionType) => [
                        'id' => $actionType->value,
                        'name' => $actionType->label(),
                    ]
                ),
            Response::HTTP_OK
        );
    }
}
