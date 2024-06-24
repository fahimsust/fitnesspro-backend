<?php

namespace App\Api\Admin\Layouts\Controllers;

use App\Api\Admin\Layouts\Requests\LayoutRequest;
use Domain\Sites\Models\Layout\Layout;
use Support\Controllers\AbstractController;
use Symfony\Component\HttpFoundation\Response;

class LayoutController extends AbstractController
{
    public function index()
    {
        return response(
            Layout::all(),
            Response::HTTP_OK
        );
    }
    public function store(LayoutRequest $request)
    {
        return response(
            Layout::Create([
                'name' => $request->name,
                'file' => $request->file,
            ]),
            Response::HTTP_CREATED
        );
    } 
    public function update(Layout $layout, LayoutRequest $request)
    {
        return response(
            $layout->update([
                'name' => $request->name,
                'file' => $request->file,
            ]),
            Response::HTTP_CREATED
        );
    }
    public function show(Layout $layout)
    {
        return response(
            $layout,
            Response::HTTP_OK
        );
    }

    public function destroy(Layout $layout)
    {
        return response(
            $layout->delete(),
            Response::HTTP_OK
        );
    }
}
