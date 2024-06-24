<?php

use Domain\Products\Models\Category\Rule\CategoryRule;
use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;
use Support\Enums\MatchAllAnyString;

return new class extends Migration {
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        $table_fields = [
            'categories' => 'rules_match_type',
            'categories_rules' => 'match_type',
        ];

        foreach ($table_fields as $table => $field) {
            Schema::table($table, function (Blueprint $table) {
                $table->string('match_anyall', 5)
                    ->default(MatchAllAnyString::ANY->value);
            });

            \Illuminate\Support\Facades\DB::table($table)
                ->where($field, 1)
                ->update([
                    'match_anyall' => MatchAllAnyString::ALL->value,
                ]);

            Schema::table($table, function (Blueprint $table) use ($field){
                $table->dropColumn($field);
            });

            Schema::table($table, function(Blueprint $table) use ($field) {
                $table->renameColumn('match_anyall', $field);
            });
        }

        Schema::table('categories_rules_attributes', function (Blueprint $table) {
            $table->boolean('matches')->default(true);
        });

        \Illuminate\Support\Facades\DB::table('categories_rules_attributes')
            ->where('match_type', 1)
            ->update([
                'matches' => false,
            ]);

        Schema::table('categories_rules_attributes', function (Blueprint $table) {
            $table->dropColumn('match_type');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        //
    }
};
