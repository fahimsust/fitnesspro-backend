<?php

namespace App\Api\Admin\Faqs\Controllers;

use App\Api\Admin\Faqs\Requests\FaqStatusRequest;
use Domain\Content\Models\Faqs\Faq;
use Support\Controllers\AbstractController;
use Symfony\Component\HttpFoundation\Response;

class FaqStatusController extends AbstractController
{
    public function __invoke(Faq $faq,FaqStatusRequest $request)
    {
        $faq->update(
            [
                'status' => $request->status,
            ]
        );
        return response(
            $faq,
            Response::HTTP_CREATED
        );
    }
}
