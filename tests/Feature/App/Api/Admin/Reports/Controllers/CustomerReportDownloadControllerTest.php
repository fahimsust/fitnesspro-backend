<?php

namespace Tests\Feature\App\Api\Admin\Reports\Controllers;

use Domain\Accounts\Models\Account;
use Domain\Accounts\Models\AccountType;
use Domain\Reports\Jobs\CreateCustomerReport;
use Domain\Reports\Models\Report;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\Queue;
use Tests\Feature\App\Api\Admin\Controllers\ControllerTestCase;
use function route;

class CustomerReportDownloadControllerTest extends ControllerTestCase
{
    protected function setUp(): void
    {
        parent::setUp();
        $this->createAndAuthAdminUser();
    }
    /** @test */
    public function can_download_excel_file()
    {
        $report = Report::factory()->create(['id' => 1000000000]);
        // Assuming you have a sample Excel file in your tests directory
        $sampleFilePath = public_path('test/report_customer_sample.xlsx');
        Storage::disk('s3')->put('report/customer/report_' . $report->id . '.xlsx', file_get_contents($sampleFilePath));

        $response = $this->get(route('admin.report.customer.download-excel', $report));

        // Assert that the response is successful (HTTP status 200)
        $response->assertStatus(200);
        // Assert that the response contains the Excel file
        $response->assertHeader('content-type', 'application/vnd.openxmlformats-officedocument.spreadsheetml.sheet');
    }

    /** @test */
    public function can_download_csv_file()
    {
        $report = Report::factory()->create(['id' => 1000000001]);
        // Assuming you have a sample CSV file in your tests directory
        $sampleFilePath = public_path('test/report_customer_sample.csv');
        Storage::disk('s3')->put('report/customer/report_' . $report->id . '.csv', file_get_contents($sampleFilePath));

        $response = $this->get(route('admin.report.customer.download-csv', $report));

        // Assert that the response is successful (HTTP status 200)
        $response->assertStatus(200);
        // Assert that the response contains the CSV file
        $response->assertHeader('content-type', 'text/csv; charset=UTF-8');
    }
}
