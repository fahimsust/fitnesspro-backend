<?php

namespace App\Api\Admin\ModuleTemplates\Controllers;


use Domain\Modules\Models\ModuleTemplate;
use Illuminate\Http\Request;
use Support\Controllers\AbstractController;
use Symfony\Component\HttpFoundation\Response;

class ModuleTemplatesController extends AbstractController
{
    public function __invoke(Request $request)
    {
        return response(
            ModuleTemplate::query()
                ->with("parentTemplate")
                ->search(
                    $request
                )
                ->when(
                    $request->filled('order_by'),
                    fn ($query) => $query->orderBy($request->order_by,$request->order_type?$request->order_type:'asc'),
                    fn ($query) => $query->orderBy('id', 'DESC')
                )
                ->paginate($request?->per_page),
            Response::HTTP_OK
        );
    }
}
