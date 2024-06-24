<?php

namespace Domain\Sites\Models\Layout;

use Domain\Sites\Models\QueryBuilders\DisplayTemplateQuery;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Support\Traits\HasModelUtilities;

/**
 * Class DisplayTemplate
 *
 * @property int $id
 * @property int $type_id
 * @property string $name
 * @property string $include
 * @property string $image_width
 * @property string $image_height
 *
 * @property DisplayTemplateType $display_templates_type
 *
 * @package Domain\Display\Models
 */
class DisplayTemplate extends Model
{
    use HasFactory,
        HasModelUtilities;
    public $timestamps = false;

    protected $table = 'display_templates';

    public function newEloquentBuilder($query)
    {
        return new DisplayTemplateQuery($query);
    }

    protected $casts = [
        'type_id' => 'int',
    ];

    protected $fillable = [
        'type_id',
        'name',
        'include',
        'image_width',
        'image_height',
    ];

    public function type()
    {
        return $this->belongsTo(DisplayTemplateType::class, 'type_id');
    }
}
