<?php

namespace Domain\Reports\Actions;


use Domain\Reports\Enums\ReportReady;
use Domain\Reports\Models\Report;
use Lorisleiva\Actions\Concerns\AsObject;
use Maatwebsite\Excel\Facades\Excel;
use Support\Exports\DataExport;
use Illuminate\Support\Facades\Storage;

class CreateCustomerReportExcel
{
    use AsObject;
    public array $header = [];

    function handle($customers,Report $report, array $header = [])
    {
        $this->header = $header;
        $data = $this->prepareData($customers);
        $totalCustomer = count($customers);
        $totalPaid = $this->calculateTotalPaid($customers);
        $totalData = ['Total Number of Customer Accounts', $totalCustomer];
        $total = $this->prepareTotal($totalPaid);
        Excel::store(new DataExport($this->header, $totalData, $data, $total), '/report/customer/report_' . $report->id . '.xlsx', 's3');
        Excel::store(new DataExport($this->header, $totalData, $data, $total), '/report/customer/report_' . $report->id . '.csv', 's3');
        $report->update(['ready'=>ReportReady::COMPLETED]);
    }

    private function prepareData($customers)
    {
        $data = [];
        $headers = [
            "Account Id",
            "First Name",
            "Last Name",
            "Username",
            "Email",
            "City",
            "State/Province",
            "Country",
            "Created",
            "Last Login",
            "Current Account Status",
            "Current Account Type",
            "Membership Started",
            "Membership Expiration",
            "Membership Level",
            "Membership Amount Paid"
        ];
        array_push($data, $headers);

        foreach ($customers as $customer) {
            foreach ($customer->memberships as $membership) {
                $end_date = $membership->end_date->format("Y-m-d H:i:s");
                if ($end_date && $membership->cancelled && $membership->cancelled < $membership->end_date) {
                    $end_date = $membership->cancelled->format("Y-m-d H:i:s");
                }
                $tempData = [
                    $customer->id,
                    $customer->first_name,
                    $customer->last_name,
                    $customer->username,
                    $customer->email,
                    $customer->defaultShippingAddress ? $customer->defaultShippingAddress->city : '',
                    $customer->defaultShippingAddress ? $customer->defaultShippingAddress->stateProvince->name : '',
                    $customer->defaultShippingAddress ? $customer->defaultShippingAddress->country->name : '',
                    $customer->created_at?$customer->created_at->format("Y-m-d H:i:s"):"",
                    $customer->lastlogin_at ? $customer->lastlogin_at->format("Y-m-d H:i:s") : "",
                    $customer->status?$customer->status->name:'',
                    $customer->type?$customer->type->name:'',
                    $membership->start_date->format("Y-m-d H:i:s"),
                    $end_date,
                    $membership->level?$membership->level->name:'',
                    $membership->subscription_price
                ];
                array_push($data, $tempData);
            }
        }

        return $data;
    }

    private function calculateTotalPaid($customers)
    {
        $totalPaid = 0;
        foreach ($customers as $customer) {
            foreach ($customer->memberships as $membership) {
                $totalPaid += $membership->subscription_price;
            }
        }
        return $totalPaid;
    }

    private function prepareTotal($totalPaid)
    {
        $total = ['TOTALS'];
        for ($i = 0; $i < 14; $i++) {
            $total[] = "";
        }
        $total[] = $totalPaid;
        return $total;
    }
}
