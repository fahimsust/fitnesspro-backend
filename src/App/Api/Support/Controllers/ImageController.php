<?php

namespace App\Api\Support\Controllers;

use App\Api\Support\Requests\ImageRequest;
use App\Api\Support\Requests\ImageSearchRequest;
use Domain\Content\Models\Image;
use Domain\Support\Models\TmpFile;
use Support\Controllers\AbstractController;
use Symfony\Component\HttpFoundation\Response;

class ImageController extends AbstractController
{
    public function index(ImageSearchRequest $request)
    {
        return response(
            Image::search($request)->paginate($request?->per_page),
            Response::HTTP_OK
        );
    }
    /**
     * Handle the incoming request.
     *
     * @param \Illuminate\Http\Request $request
     *
     * @return \Illuminate\Http\Response
     */
    public function store(ImageRequest $request)
    {
        $tmpFile = TmpFile::find($request->image);
        $filename = $tmpFile->filename;
        $tmpFile->delete();
        $image = new Image();
        $image->filename = $filename;
        $image->default_caption = $request->default_caption;
        $image->name = $request->name;
        $image->save();
        return response(
            $image,
            Response::HTTP_CREATED
        );
    }
}
