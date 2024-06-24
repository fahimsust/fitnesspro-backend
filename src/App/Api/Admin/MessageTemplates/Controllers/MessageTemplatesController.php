<?php

namespace App\Api\Admin\MessageTemplates\Controllers;


use Domain\Messaging\Models\MessageTemplate;
use Illuminate\Http\Request;
use Support\Controllers\AbstractController;
use Symfony\Component\HttpFoundation\Response;

class MessageTemplatesController extends AbstractController
{
    public function __invoke(Request $request)
    {
        return response(
            MessageTemplate::query()
                ->with("category")
                ->search(
                    $request
                )
                ->when(
                    $request->filled('order_by'),
                    fn ($query) => $query->orderBy($request->order_by,$request->order_type?$request->order_type:'asc')
                )
                ->paginate($request?->per_page),
            Response::HTTP_OK
        );
    }
}
