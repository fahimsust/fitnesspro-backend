<?php

namespace App\Api\Admin\Languages\Controllers;

use Domain\Locales\Models\Language;
use Illuminate\Http\Request;
use Support\Controllers\AbstractController;
use Symfony\Component\HttpFoundation\Response;

class LanguageController extends AbstractController
{
    public function index(Request $request)
    {
        return Response
        (
            Language::where('status',true)->search($request)->get(),
            Response::HTTP_OK
        );
    }
    public function show(Language $language)
    {
        return Response
        (
            $language,
            Response::HTTP_OK
        );
    }
}
