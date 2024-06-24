<?php

namespace Tests\Feature\Domain\Reports\Actions;

use Domain\Accounts\Models\Account;
use Domain\Accounts\Models\AccountAddress;
use Domain\Accounts\Models\AccountSpecialty;
use Domain\Accounts\Models\Membership\Subscription;
use Domain\Reports\Actions\CreateCustomerReportExcel;
use Domain\Reports\Models\Report;
use Illuminate\Support\Facades\Storage;
use Tests\TestCase;

class CreateCustomerReportExcelTest extends TestCase
{
    /** @test */
    public function handle_method_creates_excel_and_csv_files()
    {
        $report = Report::factory()->create(['id' => 10000000000]);
        $accounts = Account::factory(10)->create();
        foreach ($accounts as $account) {
            Subscription::factory()->create([
                'account_id' => $account->id,
            ]);
            AccountSpecialty::factory()->create([
                'account_id' => $account->id,
            ]);
            $accountAddress = AccountAddress::factory()->create([
                'account_id' => $account->id,
            ]);
            $account->update([
                'default_shipping_id' => $accountAddress->id
            ]);
        }
        $customers = Account::with([
            "activeMembership",
            "memberships" => ["level"],
            "specialties",
            "defaultShippingAddress" => ['stateProvince', 'country'],
            "status",
            "type",
        ])->get();

        Storage::fake('s3');

        CreateCustomerReportExcel::run($customers, $report);
        $excelFilePath = 'report/customer/report_' . $report->id . '.xlsx';
        $csvFilePath = 'report/customer/report_' . $report->id . '.csv';

        // Assert existence of files on S3 instead of local disk
        Storage::disk('s3')->assertExists($excelFilePath);
        Storage::disk('s3')->assertExists($csvFilePath);
    }
}
