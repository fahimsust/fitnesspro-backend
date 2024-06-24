<?php

namespace App\Api\Admin\Elements\Controllers;

use App\Api\Admin\Elements\Requests\ElementRequest;
use Domain\Content\Actions\DeleteElement;
use Domain\Content\Models\Element;
use Domain\Content\QueryBuilders\ElementQuery;
use Illuminate\Http\Request;
use Support\Controllers\AbstractController;
use Symfony\Component\HttpFoundation\Response;

class ElementController extends AbstractController
{
    public function index(Request $request)
    {
        return response(
            Element::query()
                ->when(
                    $request->filled('keyword'),
                    fn (ElementQuery $query) => $query->basicKeywordSearch($request->keyword)
                )
                ->when(
                    $request->filled('order_by'),
                    fn ($query) => $query->orderBy($request->order_by,$request->order_type?$request->order_type:'asc')
                )
                ->paginate($request?->per_page),
            Response::HTTP_OK
        );
    }
    public function store(ElementRequest $request)
    {
        return response(
            Element::Create([
                'title' => $request->title,
                'notes' => $request->notes,
                'content' => $request->element_content,
            ]),
            Response::HTTP_CREATED
        );
    }

    public function update(Element $element, ElementRequest $request)
    {
        return response(
            $element->update([
                'title' => $request->title,
                'content' => $request->element_content,
                'notes' => $request->notes,
            ]),
            Response::HTTP_CREATED
        );
    }

    public function show(Element $element)
    {
        return response(
            $element,
            Response::HTTP_OK
        );
    }

    public function destroy(Element $element)
    {
        return response(
            DeleteElement::run($element),
            Response::HTTP_OK
        );
    }
}
