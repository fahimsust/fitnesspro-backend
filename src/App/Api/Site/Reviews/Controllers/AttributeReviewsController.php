<?php

namespace App\Api\Site\Reviews\Controllers;

use App\Api\Site\Reviews\Requests\CreateReviewRequest;
use Domain\Products\Actions\Reviews\CreateReviewForEntity;
use Domain\Products\Models\Attribute\AttributeOption;
use Illuminate\Http\Request;
use Support\Controllers\AbstractController;
use Symfony\Component\HttpFoundation\Response;

class AttributeReviewsController extends AbstractController
{
    public function list(AttributeOption $attributeOption, Request $request)
    {
        return response(
            $attributeOption->reviews()->paginate($request?->per_page),
            Response::HTTP_OK
        );
    }
    public function store(AttributeOption $attributeOption, CreateReviewRequest $request)
    {
        return response(
            CreateReviewForEntity::run($attributeOption, $request),
            Response::HTTP_CREATED
        );
    }
}
