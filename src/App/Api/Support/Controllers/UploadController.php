<?php

namespace App\Api\Support\Controllers;

use App\Api\Support\Requests\ImageRequest;
use App\Api\Support\Requests\ImageSearchRequest;
use Domain\Content\Models\Image;
use Domain\Support\Models\TmpFile;
use Support\Controllers\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Illuminate\Support\Facades\Storage;
use \Illuminate\Http\Request;

class UploadController extends AbstractController
{
    function store(Request $request)
    {
        $folder = "image";
        if($request->folder)
        {
            $folder = $request->folder;
        }
        $file = $request->file('filepond');
        $fileName = $file->getClientOriginalName();
        $filename = pathinfo($fileName, PATHINFO_FILENAME);
        $extension = pathinfo($fileName, PATHINFO_EXTENSION);
        $newName = $filename."_".time().'.'.$extension;
        $file->storeAs($folder,$newName,'s3');
        $tmpFile = New TmpFile();
        $tmpFile->filename=$folder."/".$newName;
        $tmpFile->save();
        return response(
            $tmpFile,
            Response::HTTP_CREATED
        );
    }

}
