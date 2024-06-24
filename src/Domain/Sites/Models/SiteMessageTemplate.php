<?php

namespace Domain\Sites\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Support\Traits\HasModelUtilities;

class SiteMessageTemplate extends Model
{
    use HasFactory,
        HasModelUtilities;

    protected $guarded = [];

    protected $table = 'sites_message_templates';

    public function site()
    {
        return $this->belongsTo(
            Site::class,
            'site_id',
            'site_id'
        );
    }
}
