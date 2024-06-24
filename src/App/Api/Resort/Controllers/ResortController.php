<?php

namespace App\Api\Resort\Controllers;

use App\Api\Resort\Requests\ResortRelationsRequest;
use App\Api\Resort\Requests\ShowResortRelationsRequest;
use Domain\Resorts\Models\Resort;
use Support\Controllers\AbstractController;

class ResortController extends AbstractController
{
    /**
     * Display a listing of the resource.
     *
     * @param  ResortRelationsRequest  $request
     *
     * @return \Illuminate\Http\Response
     */
    public function index(ResortRelationsRequest $request)
    {
        $resortQuery = Resort::joinAttributeOption();
//        dd(Query::toSql($resortQuery));

        if ($request->exists('relations')) {
            $resorts = $resortQuery->with($request->relations)->paginate();
        } else {
            $resorts = $resortQuery->paginate();
        }

        return ['resorts' => $resorts];
    }

    public function show(Resort $resort, ShowResortRelationsRequest $request)
    {
        if ($request->exists('relations')) {
            $limitRelations = ['specialties']; //, 'albums.photos'];

            $resort->load(array_diff($request->relations, $limitRelations));

            foreach (array_intersect($request->relations, $limitRelations) as $relation) {
                $resort->limitRelation($relation, 25);
            }

//            $resort->limitRelation('specialties');
        }

        return $resort;
    }
}
