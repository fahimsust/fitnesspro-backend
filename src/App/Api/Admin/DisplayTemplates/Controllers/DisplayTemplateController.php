<?php

namespace App\Api\Admin\DisplayTemplates\Controllers;

use App\Api\Admin\DisplayTemplates\Requests\DisplayTemplateRequest;
use Domain\Sites\Actions\Layout\DeleteDisplayTemplate;
use Domain\Sites\Models\Layout\DisplayTemplate;
use Illuminate\Http\Request;
use Support\Controllers\AbstractController;
use Symfony\Component\HttpFoundation\Response;

class DisplayTemplateController extends AbstractController
{
    public function index(Request $request)
    {
        return response(
            DisplayTemplate::query()
                ->search($request)
                ->when(
                    $request->filled('order_by'),
                    fn ($query) => $query->orderBy($request->order_by,$request->order_type?$request->order_type:'asc')
                )
                ->with('type')
                ->paginate($request?->per_page),
            Response::HTTP_OK
        );
    }
    public function store(DisplayTemplateRequest $request)
    {
        return Response(
            DisplayTemplate::create($request->all()),
            Response::HTTP_CREATED
        );
    }
    public function update(DisplayTemplateRequest $request, DisplayTemplate $displayTemplate)
    {
        return Response(
            $displayTemplate->update($request->all()),
            Response::HTTP_CREATED
        );
    }
    public function destroy(DisplayTemplate $displayTemplate)
    {
        return Response(
            DeleteDisplayTemplate::run($displayTemplate),
            Response::HTTP_OK
        );
    }
}
