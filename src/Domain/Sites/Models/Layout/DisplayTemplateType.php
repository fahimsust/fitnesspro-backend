<?php

namespace Domain\Sites\Models\Layout;

use Illuminate\Database\Eloquent\Collection;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Support\Traits\HasModelUtilities;

/**
 * Class DisplayTemplatesType
 *
 * @property int $id
 * @property string $name
 *
 * @property Collection|array<DisplayTemplate> $display_templates
 *
 * @package Domain\Display\Models
 */
class DisplayTemplateType extends Model
{
    use HasFactory,
        HasModelUtilities;
    public $timestamps = false;

    protected $table = 'display_templates_types';

    protected $fillable = [
        'name',
    ];

    public function templates()
    {
        return $this->hasMany(DisplayTemplate::class, 'type_id');
    }
}
