<?php

use Domain\Products\Models\Brand;
use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;
use Illuminate\Support\Facades\DB;

return new class extends Migration
{
    public function up()
    {
        // For every set of duplicate brands, identify the primary (e.g., oldest) brand
        $duplicates = DB::select("
            SELECT MIN(id) as primary_id, name
            FROM brands
            GROUP BY name
            HAVING COUNT(*) > 1
        ");

        foreach ($duplicates as $duplicate) {
            // Update categoryBrands relationships to point to the primary brand
            DB::table('categories_brands')
                ->where('brand_id', '<>', $duplicate->primary_id)
                ->whereIn('brand_id', function ($query) use ($duplicate) {
                    $query->select('id')
                        ->from('brands')
                        ->where('name', $duplicate->name)
                        ->where('id', '<>', $duplicate->primary_id);
                })
                ->update(['brand_id' => $duplicate->primary_id]);

            // Update productDetail relationships to point to the primary brand
            DB::table('products_details')
                ->where('brand_id', '<>', $duplicate->primary_id)
                ->whereIn('brand_id', function ($query) use ($duplicate) {
                    $query->select('id')
                        ->from('brands')
                        ->where('name', $duplicate->name)
                        ->where('id', '<>', $duplicate->primary_id);
                })
                ->update(['brand_id' => $duplicate->primary_id]);
        }

        // Remove the duplicates, keeping only the primary brand for each name
        DB::statement("
            DELETE b1 FROM brands b1
            JOIN brands b2
            WHERE b1.id > b2.id AND b1.name = b2.name
        ");

        // Enforce uniqueness on the name column
        Schema::table(Brand::Table(), function (Blueprint $table) {
            $table->unique('name');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('brands', function (Blueprint $table) {
            $table->dropUnique(['name']);
        });
    }
};

