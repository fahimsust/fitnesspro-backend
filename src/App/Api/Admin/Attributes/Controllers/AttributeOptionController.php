<?php

namespace App\Api\Admin\Attributes\Controllers;

use App\Api\Admin\Attributes\Requests\AttributeOptionRequest;
use App\Api\Admin\Attributes\Requests\AttributeOptionUpdateRequest;
use Domain\Products\Actions\Attributes\CreateAttributeOption;
use Domain\Products\Actions\Attributes\DeleteAttributeOption;
use Domain\Products\Actions\Attributes\UpdateAttributeOption;
use Domain\Products\Models\Attribute\AttributeOption;
use Support\Controllers\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Illuminate\Http\Request;

class AttributeOptionController extends AbstractController
{
    public function index(Request $request)
    {
        return response(
            AttributeOption::whereAttributeId($request->attribute_id)->orderBy('display')->get(),
            Response::HTTP_OK
        );
    }
    public function store(AttributeOptionRequest $request)
    {
        return response(
            CreateAttributeOption::run($request),
            Response::HTTP_CREATED
        );
    }

    public function update(
        AttributeOption $attributeOption,
        AttributeOptionUpdateRequest $request
    ) {
        return response(
            UpdateAttributeOption::run($attributeOption, $request),
            Response::HTTP_CREATED
        );
    }

    public function destroy(AttributeOption $attributeOption)
    {
        return response(
            DeleteAttributeOption::run($attributeOption),
            Response::HTTP_OK
        );
    }
}
