<?php

use Domain\CustomForms\Models\CustomField;
use Domain\CustomForms\Models\CustomFieldOption;
use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;
use Illuminate\Support\Facades\DB;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::create('custom_field_options', function (Blueprint $table) {
            $table->id();
            $table->string('display');
            $table->string('value');
            $table->integer('field_id');
            $table->integer('rank')->default(0)->nullable();
            $table->timestamps();
        });
        $allField = CustomField::where('options',"!=","''")
            ->select(['id','options'])
            ->get();

        foreach($allField as $value)
        {
            $options = json_decode($value->options);
            if($options && count($options)>0)
            foreach($options as $oValue)
            {
                if(isset($oValue->val) && isset($oValue->dis))
                CustomFieldOption::create(
                    [
                        'field_id'=>$value->id,
                        'display' => isset($oValue->dis) ? $oValue->dis : null,
                        'value' => isset($oValue->val) ? $oValue->val : null,
                        'rank' => isset($oValue->rank) ? $oValue->rank : 0,
                    ]
                );
            }

        }
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('section_custom_field_options');
    }
};
