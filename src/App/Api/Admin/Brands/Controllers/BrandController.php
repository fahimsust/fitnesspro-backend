<?php

namespace App\Api\Admin\Brands\Controllers;

use App\Api\Admin\Brands\Requests\BrandRequest;
use Domain\Products\Actions\Brand\DeleteBrand;
use Domain\Products\Models\Brand;
use Support\Controllers\AbstractController;
use Symfony\Component\HttpFoundation\Response;

class BrandController extends AbstractController
{
    public function index()
    {
        return response(
            Brand::orderBy('name')->get(),
            Response::HTTP_OK
        );
    }
    public function store(BrandRequest $request)
    {
        return response(
            Brand::Create([
                'name' => $request->name,
            ]),
            Response::HTTP_CREATED
        );
    }

    public function update(Brand $brand, BrandRequest $request)
    {
        return response(
            $brand->update([
                'name' => $request->name,
            ]),
            Response::HTTP_CREATED
        );
    }
    public function show(Brand $brand)
    {
        return response(
            $brand,
            Response::HTTP_OK
        );
    }

    public function destroy(Brand $brand)
    {
        return response(
            DeleteBrand::run($brand),
            Response::HTTP_OK
        );
    }
}
