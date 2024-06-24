<?php

namespace App\Api\Admin\CustomForms\Controllers;

use Domain\CustomForms\Models\CustomForm;
use Support\Controllers\AbstractController;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;

class CustomFormsController extends AbstractController
{
    public function __invoke(Request $request)
    {
        return response(
            CustomForm::query()
                ->basicKeywordSearch($request->keyword)
                ->when(
                    $request->filled('order_by'),
                    fn ($query) => $query->orderBy($request->order_by,$request->order_type?$request->order_type:'asc')
                )
                ->paginate($request?->per_page),
            Response::HTTP_OK
        );
    }
}
