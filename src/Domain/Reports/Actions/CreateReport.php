<?php

namespace Domain\Reports\Actions;


use Domain\Reports\Models\Report;
use Illuminate\Foundation\Http\FormRequest;
use Carbon\Carbon;
use Lorisleiva\Actions\Concerns\AsObject;

class CreateReport
{
    use AsObject;

    public function handle(
        FormRequest $request,
        int $type_id
    ): Report {
        $criteria = (array)$request->except("name");
        $report = Report::create(
            [
                'name' => $request->name,
                'created' => Carbon::now(),
                'criteria' => $criteria,
                'type_id' => $type_id,
                'ready' => 0,
                'from_date' => $request->start_date,
                'to_date' => $request->end_date,
                'breakdown' => 0,
                'restart' => 0,
            ]
        );

        return $report;
    }
}
