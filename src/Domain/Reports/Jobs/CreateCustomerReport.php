<?php

namespace Domain\Reports\Jobs;

use Domain\Reports\Actions\BuildCustomerReport;
use Domain\Reports\Actions\CreateCustomerReportExcel;
use Domain\Reports\Models\Report;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Queue\SerializesModels;

class CreateCustomerReport implements ShouldQueue
{
    use Dispatchable, InteractsWithQueue, Queueable, SerializesModels;

    public function __construct(
        public Object $critaria,
        public Report $report,
    ) {
    }

    public function handle()
    {
        [$customers,$header] = BuildCustomerReport::run($this->critaria,$this->report);
        CreateCustomerReportExcel::run($customers,$this->report,$header);
    }
}
