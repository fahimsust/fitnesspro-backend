<?php

namespace App\Api\Admin\MessageTemplates\Controllers;

use App\Api\Admin\MessageTemplates\Requests\MessageTemplateCategoryRequest;
use Domain\Messaging\Models\MessageTemplateCategory;
use Support\Controllers\AbstractController;
use Symfony\Component\HttpFoundation\Response;

class MessageTemplateCategoryController extends AbstractController
{
    public function index()
    {
        return Response(
            MessageTemplateCategory::with('parent')->get(),
            Response::HTTP_OK
        );
    }
    public function store(MessageTemplateCategoryRequest $request)
    {
        return Response(
            MessageTemplateCategory::create($request->all()),
            Response::HTTP_CREATED
        );
    }
    public function update(MessageTemplateCategoryRequest $request, MessageTemplateCategory $messageTemplateCategory)
    {
        return Response(
            $messageTemplateCategory->update($request->all()),
            Response::HTTP_CREATED
        );
    }
    public function destroy(MessageTemplateCategory $messageTemplateCategory)
    {
        return Response(
            $messageTemplateCategory->delete(),
            Response::HTTP_OK
        );
    }
}
