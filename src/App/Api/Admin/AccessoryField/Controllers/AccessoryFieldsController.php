<?php

namespace App\Api\Admin\AccessoryField\Controllers;

use App\Api\Admin\AccessoryField\Requests\AccessoryFieldSearchRequest;
use Domain\Products\Models\Product\AccessoryField\AccessoryField;
use Domain\Products\QueryBuilders\AccessoryFieldQuery;
use Support\Controllers\AbstractController;
use Symfony\Component\HttpFoundation\Response;

class AccessoryFieldsController extends AbstractController
{
    public function __invoke(AccessoryFieldSearchRequest $request)
    {
        return response(
            AccessoryField::query()
                ->search($request)
                ->when(
                    $request->filled('order_by'),
                    fn (AccessoryFieldQuery $query) => $query->orderBy($request->order_by,$request->order_type?$request->order_type:'asc')
                )
                ->paginate($request?->per_page),
            Response::HTTP_OK
        );
    }
}
