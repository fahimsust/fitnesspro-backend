<?php

namespace App\Api\Admin\Attributes\Controllers;

use App\Api\Admin\Attributes\Requests\AttributesOfSetRequest;
use Domain\Products\Models\Attribute\AttributeSet;
use Support\Controllers\AbstractController;
use Symfony\Component\HttpFoundation\Response;

class AttributesController extends AbstractController
{
    public function __invoke(AttributesOfSetRequest $request)
    {
        return response(
            AttributeSet::find($request->set_id)
                ->when(
                    $request->filled('order_by'),
                    fn ($query) => $query->orderBy($request->order_by,$request->order_type?$request->order_type:'asc')
                )
                ->attributes()->withCount('options')
                ->paginate($request?->per_page),
            Response::HTTP_OK
        );
    }
}
