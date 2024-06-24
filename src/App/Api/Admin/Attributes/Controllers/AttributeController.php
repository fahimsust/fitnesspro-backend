<?php

namespace App\Api\Admin\Attributes\Controllers;

use App\Api\Admin\Attributes\Requests\AttributeRequest;
use App\Api\Admin\Attributes\Requests\AttributesOfSetRequest;
use App\Api\Admin\Attributes\Requests\AttributeUpdateRequest;
use Domain\Products\Actions\Attributes\CreateAttribute;
use Domain\Products\Actions\Attributes\DeleteAttribute;
use Domain\Products\Actions\Attributes\UpdateAttribute;
use Domain\Products\Models\Attribute\Attribute;
use Domain\Products\Models\Attribute\AttributeSet;
use Support\Controllers\AbstractController;
use Symfony\Component\HttpFoundation\Response;

class AttributeController extends AbstractController
{
    public function index(AttributesOfSetRequest $request)
    {
        return response(
            AttributeSet::find($request->set_id)->attributes->each->load('options'),
            Response::HTTP_OK
        );
    }

    public function store(AttributeRequest $request)
    {
        return response(
            CreateAttribute::run($request),
            Response::HTTP_CREATED
        );
    }

    public function update(Attribute $attribute, AttributeUpdateRequest $request)
    {
        return response(
            UpdateAttribute::run($attribute, $request),
            Response::HTTP_CREATED
        );
    }

    public function destroy(Attribute $attribute)
    {
        return response(
            DeleteAttribute::run($attribute),
            Response::HTTP_OK
        );
    }
}
