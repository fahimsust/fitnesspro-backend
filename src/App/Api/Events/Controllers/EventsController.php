<?php

namespace App\Api\Events\Controllers;

use Domain\Events\Models\Event;
use Domain\Events\Requests\SearchEventsRequest;
use Support\Controllers\AbstractController;
use Support\QueryBuilders\SearchQuery;

class EventsController extends AbstractController
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(SearchEventsRequest $request)
    {
        $searchEvents = (new SearchQuery(Event::query()->with(['account'])->select('*'), $request))
            ->startRange('event_starts', 'sdate')
            ->endRange('event_ends', 'edate')
            ->where('title', '%like%')
            ->where('city', '%like%')
            ->where('state_alpha2', 'like', null, 'state')
            ->where('country_alpha2', 'like', null, 'country');

//        dd(Query::toSql($searchEvents->query));

        return ['events' => $searchEvents->paginate()];
    }

    /**
     * Display the specified resource.
     *
     * @param  Event  $event
     *
     * @return \Illuminate\Http\Response
     */
    public function show(Event $event)
    {
        return ['event' => $event->load(['account', 'state', 'country'])];
    }
}
