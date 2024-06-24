<?php

namespace App\Api\Accounts\Controllers;

use App\Api\Accounts\Requests\SearchAccountTripsRequest;
use Domain\Accounts\Models\Account;
use Domain\Trips\Models\TripFlyer;
use Domain\Trips\QueryBuilders\AccountTrip;
use Support\Controllers\AbstractController;
use Support\QueryBuilders\SearchQuery;

class TripController extends AbstractController
{
    /**
     * Display a listing of the resource.
     *
     * @param  Account  $account
     * @param  SearchAccountTripsRequest  $request
     *
     * @return array
     */
    public function index(Account $account, SearchAccountTripsRequest $request)
    {
        $searchTrips = (new SearchQuery(AccountTrip::StartQuery($account), $request))
            ->startRange('trip_starts', 'pov.start_date')
            ->endRange('trip_ends', 'pov.end_date');

        return ['trips' => $searchTrips->paginate()];
    }

    /**
     * Display the specified resource.
     *
     * @param  Account  $account
     * @param $tripId
     *
     * @return \Illuminate\Http\Response
     * Account $account, Request $request
     */
    public function show(Account $account, $tripId)
    {
        $trip = AccountTrip::find($account, $tripId);
//        $orderProduct = OrderProduct::with('details')->findOrFail($trip->id);

        try {
            $flyer = TripFlyer::FindByOrderProductId($trip->id);
        } catch (\Exception $e) {
            $flyer = false;
        }

        return ['trip' => $trip, 'flyer' => $flyer]; //, 'order_product' => $orderProduct];
    }
}
