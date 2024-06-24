<?php

use Domain\Reports\Models\Report;
use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::table(Report::Table(), function (Blueprint $table) {
            $table->renameColumn('criteria', 'criteria_old');
            $table->renameColumn('variables', 'variables_old');
        });
        Schema::table(Report::Table(), function (Blueprint $table) {
            $table->json('criteria')->nullable();
            $table->json('variables')->nullable();
        });
        $reports = DB::table('reports')
            ->select('id', 'criteria_old')
            ->whereNull('criteria')
            ->get();
        foreach ($reports as $report) {
            if ($report->criteria_old) {
                $jsonDecoded = html_entity_decode($report->criteria_old);
                $json = json_decode($jsonDecoded, true);
                if ($json !== null) {
                    Report::query()
                        ->where('id', $report->id)
                        ->update(['criteria' => $json]);
                }
            }
        }

        $reports = DB::table('reports')
            ->select('id', 'variables_old')
            ->whereNull('variables')
            ->get();
        foreach ($reports as $report) {
            if ($report->variables_old) {
                $jsonDecoded = html_entity_decode($report->variables_old);
                $json = json_decode($jsonDecoded, true);
                if ($json !== null) {
                    Report::query()
                        ->where('id', $report->id)
                        ->update(['variables' => $json]);
                }
            }
        }

    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        //
    }
};
