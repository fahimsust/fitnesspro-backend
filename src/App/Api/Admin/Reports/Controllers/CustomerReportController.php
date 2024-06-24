<?php
namespace App\Api\Admin\Reports\Controllers;

use App\Api\Admin\Reports\Requests\CustomerReportRequest;
use Domain\Reports\Actions\BuildCustomerReport;
use Domain\Reports\Actions\CreateCustomerReportExcel;
use Domain\Reports\Actions\CreateReport;
use Domain\Reports\Actions\ReadExcelFileCustomerReport;
use Domain\Reports\Models\Report;
use Illuminate\Http\Request;
use Domain\Reports\Jobs\CreateCustomerReport;
use Support\Controllers\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Illuminate\Support\Facades\Storage;
class CustomerReportController extends AbstractController
{
    public function index(Request $request)
    {
        return response(
            Report::when(
                $request->filled('order_by'),
                fn ($query) => $query->orderBy($request->order_by,$request->order_type?$request->order_type:'asc')
            )->paginate($request?->per_page),
            Response::HTTP_OK
        );
    }
    public function store(CustomerReportRequest $request)
    {
        $report = CreateReport::run($request,13);
        //[$customers,$header] = BuildCustomerReport::run((Object)$report->criteria,$report);
        //CreateCustomerReportExcel::run($customers,$report,$header);
        CreateCustomerReport::dispatch(
            (Object)$report->criteria,
            $report
        );
        return response(
            $report,
            Response::HTTP_OK
        );
    }
    public function update(Report $customer,Request $request)
    {
        CreateCustomerReport::dispatch(
            (Object)$customer->criteria,
            $customer
        );
        return response(
            $customer,
            Response::HTTP_OK
        );
    }
    public function show(Report $customer)
    {
        $filePath = 'report/customer/report_' . $customer->id . '.xlsx';
        $dataCollection = ReadExcelFileCustomerReport::run($filePath);
        return response(
            $dataCollection,
            Response::HTTP_OK
        );
    }
    public function destroy(Report $customer)
    {
        Storage::disk('s3')->delete([
            'report/customer/report_' . $customer->id . '.xlsx',
            'report/customer/report_' . $customer->id . '.csv',
        ]);
        $customer->delete();

        return response(null, Response::HTTP_NO_CONTENT);
    }
}
