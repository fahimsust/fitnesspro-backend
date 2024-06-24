<?php

namespace App\Api\Admin\CustomForms\Controllers;

use App\Api\Admin\CustomForms\Requests\CustomFormRequest;
use App\Api\Admin\CustomForms\Requests\FormSectionRequest;
use Domain\CustomForms\Actions\DeleteFormSection;
use Domain\CustomForms\Models\FormSection;
use Support\Controllers\AbstractController;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;

class FormSectionController extends AbstractController
{
    public function index(Request $request)
    {
        return response(
            FormSection::where('form_id',$request->form_id)->orderBy('id','desc')->with('fields')->get(),
            Response::HTTP_OK
        );
    }
    public function store(FormSectionRequest $request)
    {
        return response(
            FormSection::Create([
                'title' => $request->title,
                'rank' => $request->rank,
                'form_id'=>$request->form_id
            ]),
            Response::HTTP_CREATED
        );
    }

    public function update(FormSection $customFormSection, FormSectionRequest $request)
    {
        return response(
            $customFormSection->update([
                'title' => $request->title,
                'rank' => $request->rank,
                'form_id'=>$request->form_id
            ]),
            Response::HTTP_CREATED
        );
    }

    public function destroy(FormSection $customFormSection)
    {
        return response(
            DeleteFormSection::run($customFormSection),
            Response::HTTP_OK
        );
    }
}
