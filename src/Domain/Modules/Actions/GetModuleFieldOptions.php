<?php

namespace Domain\Modules\Actions;

use Domain\Modules\Models\ModuleField;
use Illuminate\Support\Facades\DB;
use Support\Contracts\AbstractAction;

class GetModuleFieldOptions extends AbstractAction
{
    public function __construct(
        public ModuleField  $moduleField
    )
    {
    }

    public function execute()
    {
        $options = [];
        $setting = json_decode($this->moduleField->field_setting);

        if($setting->type == "option")
        {
            $options = $setting->options;
        }
        if($setting->type == "query")
        {
            $options = DB::select($setting->query);
        }

        return ['type'=>$setting->type,'options'=>$options];
    }
}
