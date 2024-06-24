<?php

namespace App\Api\Slugs\Controllers;

use Support\Controllers\AbstractController;
use Symfony\Component\HttpKernel\Exception\NotFoundHttpException;

class ParseController extends AbstractController
{
    public function show(string $slug)
    {
        //todo: parse slug and return type (component page) and needed data

//        return new ParsedSlugDataResource($slug);
        return [
            'type' => match ($slug) {
                'is-category' => 'category',
                //advanced search
                'is-product' => 'product',
                //page
                default => throw new NotFoundHttpException()
            },
        ];
    }
}
