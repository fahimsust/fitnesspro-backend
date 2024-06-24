<?php

namespace Domain\Reports\Actions;

use Lorisleiva\Actions\Concerns\AsObject;
use Illuminate\Support\Collection;
use Maatwebsite\Excel\Excel;
use Illuminate\Support\Facades\Storage;
use stdClass;

class ReadExcelFileCustomerReport
{
    use AsObject;

    public function handle($filePath)
    {
        $excel = app(Excel::class);
        $collection = [];
        $headers = [
            'account_id',
            'first_name',
            'last_name',
            'username',
            'email',
            'city',
            'state',
            'country',
            'created',
            'last_login',
            'status',
            'type',
            'membership_start',
            'membership_end',
            'membership_level',
            'membership_paid'
        ];
        Storage::disk('local')->put(public_path('temp.xlsx'), Storage::disk('s3')->get($filePath));
        $rows = $excel->toCollection(new stdClass,public_path('temp.xlsx'))->first();
        Storage::disk('local')->delete(public_path('temp.xlsx'));
        $fullReport = [];
        $searchCriteria = [];
        $totalCustomer = 0;

        $startReading = false;
        foreach ($rows as $key=>$row) {
            $rowDatas = $row->toArray();
            $readTotal = false;
            foreach ($rowDatas as $rowData) {
                if($key == 0 && $rowData)
                {
                    $searchCriteria[] = $rowData;
                }
                if($rowData == "Total Number of Customer Accounts")
                {
                    $readTotal = true;
                    continue;
                }
                if($readTotal)
                {
                    $readTotal = false;
                    $totalCustomer = $rowData;
                }
            }
            // Check if we should start reading
            if (!$startReading) {
                $accountIdIndex = array_search("Account Id", $rowDatas);
                if ($accountIdIndex !== false) {
                    $startReading = true;
                    continue; // Skip processing header row
                }
            }

            if (!$startReading) {
                continue;
            }

            $object = [];
            foreach ($rowDatas as $key => $rowData) {
                if (isset($headers[$key])) {
                    $object[$headers[$key]] = $rowData;
                }
            }
            $collection[] = (object) $object;
        }
        $fullReport = [
            "criteria" => $searchCriteria,
            "total_customer" => $totalCustomer,
            'collection' => new Collection($collection)
        ];


        return $fullReport;
    }
}
