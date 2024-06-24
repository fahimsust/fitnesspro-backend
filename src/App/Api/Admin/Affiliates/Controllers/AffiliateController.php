<?php

namespace App\Api\Admin\Affiliates\Controllers;

use App\Api\Admin\Affiliates\Requests\AffiliateSearchRequest;
use App\Api\Admin\Affiliates\Requests\CreateAffiliateRequest;
use App\Api\Admin\Affiliates\Requests\UpdateAffiliateRequest;
use Domain\Affiliates\Actions\CreateAffiliate;
use Domain\Affiliates\Actions\UpdateAffiliate;
use Domain\Affiliates\Models\Affiliate;
use Domain\Affiliates\QueryBuilders\AffiliateQuery;
use Support\Controllers\AbstractController;
use Symfony\Component\HttpFoundation\Response;

class AffiliateController extends AbstractController
{
    /**
     * Handle the incoming request.
     *
     * @param \Illuminate\Http\Request $request
     *
     * @return \Illuminate\Http\Response
     */
    public function index(AffiliateSearchRequest $request)
    {
        return response(
            Affiliate::query()
                ->search($request)
                ->when(
                    $request->filled('order_by'),
                    fn (AffiliateQuery $query) => $query->orderBy($request->order_by,$request->order_type?$request->order_type:'asc')
                )
                ->paginate($request?->per_page),
            Response::HTTP_OK
        );
    }

    public function update(Affiliate $affiliate, UpdateAffiliateRequest $request)
    {
        return response(
            UpdateAffiliate::run($affiliate, $request),
            Response::HTTP_CREATED
        );
    }
    public function store(CreateAffiliateRequest $request)
    {
        return response(
            CreateAffiliate::run($request),
            Response::HTTP_CREATED
        );
    }

    public function show(Affiliate $affiliate)
    {
        return response(
            Affiliate::with('account')->findOrFail($affiliate->id),
            Response::HTTP_OK
        );
    }

    public function destroy(Affiliate $affiliate)
    {
        return response(
            $affiliate->update(['status' => false]),
            Response::HTTP_OK
        );
    }
}
