<?php

namespace App\Api\Admin\Attributes\Controllers;

use App\Api\Admin\Attributes\Requests\AttributeSetRequest;
use Domain\Products\Actions\Attributes\DeleteAttributeSet;
use Domain\Products\Models\Attribute\AttributeSet;
use Support\Controllers\AbstractController;
use Symfony\Component\HttpFoundation\Response;

class AttributeSetController extends AbstractController
{
    public function index()
    {
        return response(
            AttributeSet::orderBy('name')->get(),
            Response::HTTP_CREATED
        );
    }
    public function store(AttributeSetRequest $request)
    {
        return response(
            AttributeSet::create(['name' => $request->name]),
            Response::HTTP_CREATED
        );
    }

    public function update(AttributeSet $attributeSet, AttributeSetRequest $request)
    {
        return response(
            $attributeSet->update(['name' => $request->name]),
            Response::HTTP_CREATED
        );
    }

    public function destroy(AttributeSet $attributeSet)
    {
        return response(
            DeleteAttributeSet::run($attributeSet),
            Response::HTTP_OK
        );
    }
}
