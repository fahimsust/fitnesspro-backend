<?php

namespace App\Api\Admin\Attributes\Controllers;

use Domain\Products\Models\Attribute\AttributeSet;
use Illuminate\Http\Request;
use Support\Controllers\AbstractController;
use Symfony\Component\HttpFoundation\Response;

class AttributeSetsController extends AbstractController
{
    public function __invoke(Request $request)
    {
        return response(
            AttributeSet::withCount('attributes')
                ->when(
                    $request->filled('order_by'),
                    fn ($query) => $query->orderBy($request->order_by,$request->order_type?$request->order_type:'asc')
                )
                ->paginate($request?->per_page),
            Response::HTTP_OK
        );
    }
}
