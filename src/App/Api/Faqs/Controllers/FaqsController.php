<?php
namespace App\Api\Faqs\Controllers;

use Domain\Content\Models\Faqs\FaqCategory;
use Support\Controllers\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Illuminate\Http\Request;

class FaqsController extends AbstractController
{
    public function __invoke(Request $request)
    {
        return response(
            FaqCategory::query()
                ->where('status',true)
                ->orderBy('rank')
                ->with([
                    'faqs' => function ($query) {
                        $query->where('status',true)->orderBy('rank');
                    }
                ])
                ->get(),
            Response::HTTP_OK
        );
    }
}
