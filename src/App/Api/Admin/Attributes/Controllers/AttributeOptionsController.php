<?php

namespace App\Api\Admin\Attributes\Controllers;

use App\Api\Admin\Attributes\Requests\AttributeOptionsRequest;
use Domain\Products\Models\Attribute\Attribute;
use Support\Controllers\AbstractController;
use Symfony\Component\HttpFoundation\Response;

class AttributeOptionsController extends AbstractController
{
    public function __invoke(AttributeOptionsRequest $request)
    {
        return response(
            Attribute::find($request->attribute_id)
                ->when(
                    $request->filled('order_by'),
                    fn ($query) => $query->orderBy($request->order_by,$request->order_type?$request->order_type:'asc')
                )
                ->options()
                ->paginate($request?->per_page),
            Response::HTTP_OK
        );
    }
}
