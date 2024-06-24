<?php

namespace App\Api\Admin\Reports\Controllers;

use Domain\Reports\Models\Report;
use Illuminate\Support\Facades\Storage;
use Support\Controllers\AbstractController;

class CustomerReportDownloadController extends AbstractController
{
    public function downloadExcel(Report $report)
    {
        $filePath = 'report/customer/report_' . $report->id . '.xlsx';

        // Retrieve the file contents from S3
        $fileContents = Storage::disk('s3')->get($filePath);

        // Return a response with the file contents
        return response()->streamDownload(function () use ($fileContents) {
            echo $fileContents;
        }, 'customer_report.xlsx', ['content-type' => 'application/vnd.openxmlformats-officedocument.spreadsheetml.sheet']);
    }

    public function downloadCsv(Report $report)
    {
        $filePath = 'report/customer/report_' . $report->id . '.csv';

        // Retrieve the file contents from S3
        $fileContents = Storage::disk('s3')->get($filePath);

        // Return a response with the file contents
        return response()->streamDownload(function () use ($fileContents) {
            echo $fileContents;
        }, 'customer_report.csv', ['content-type' => 'text/csv']);
    }
}
