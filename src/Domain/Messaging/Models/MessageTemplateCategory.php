<?php

namespace Domain\Messaging\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Support\Traits\HasModelUtilities;

class MessageTemplateCategory extends Model
{
    use HasFactory,
        HasModelUtilities;
    protected $table = 'message_template_categories';

    public function parent()
    {
        return $this->belongsTo(MessageTemplateCategory::class, 'parent_id');
    }
    public function messageTemplates()
    {
        return $this->hasMany(MessageTemplate::class, 'category_id');
    }
}
