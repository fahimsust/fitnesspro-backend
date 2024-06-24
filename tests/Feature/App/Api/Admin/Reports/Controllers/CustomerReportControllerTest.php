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

class CustomerReportControllerTest extends ControllerTestCase
{
    protected function setUp(): void
    {
        parent::setUp();
        $this->createAndAuthAdminUser();
    }

    /** @test */
    public function can_index_reports()
    {
        Report::factory(10)->create();

        $this->getJson(route('admin.report.customer.index'))
            ->assertOk()
            ->assertJsonStructure([
                'data' => [
                    '*' => [
                        'id',
                        'name'
                    ]
                ]
            ])->assertJsonCount(10, 'data');
    }

    /** @test */
    public function can_store_report_and_dispatch_job()
    {
        Queue::fake();
        Storage::fake('local');
        $accountType = AccountType::factory()->create();
        Account::factory(10)->create([
            'type_id' => $accountType->id,
        ]);
        $response = $this->postJson(route('admin.report.customer.store'), [
            'name' => 'Test Report',
            'account_type_id' => [$accountType->id],
        ])->assertOk()
            ->assertJsonStructure(['id', 'name']);

        Queue::assertPushed(CreateCustomerReport::class, function ($job) use ($response) {
            return $job->report->id === $response['id'];
        });
    }

    /** @test */
    public function can_update_report_and_dispatch_job()
    {
        Queue::fake();

        $report = Report::factory()->create(['id' => 10000000000]);

        $this->putJson(route('admin.report.customer.update', $report))->assertOk();

        Queue::assertPushed(CreateCustomerReport::class, function ($job) use ($report) {
            return $job->report->id === $report->id;
        });
    }
    /** @test */
    public function can_show_report()
    {
        $report = Report::factory()->create(['id' => 10000000000]);
        $filePath = 'report/customer/report_' . $report->id . '.xlsx'; // Adjust the path as per your S3 structure

        // Assuming you have a sample Excel file in your tests directory
        $sampleFilePath = public_path('test/report_customer_sample.xlsx');

        // Upload the sample file to S3
        Storage::disk('s3')->put($filePath, file_get_contents($sampleFilePath));

        $this->getJson(route('admin.report.customer.show', $report))
            ->assertOk()->assertJsonStructure([
                    'collection' => [
                        '*' => [
                            'account_id',
                        ]
                    ]
                ]);
    }

    /** @test */
    public function can_destroy_report()
    {
        Storage::fake('local');
        $report = Report::factory()->create(['id' => 10000000000]);

        $this->deleteJson(route('admin.report.customer.destroy', $report))
            ->assertNoContent();

        $this->assertDatabaseCount(Report::Table(), 0);
    }
}
