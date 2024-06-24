<?php

namespace Domain\CustomForms\Models;

use Illuminate\Database\Eloquent\Model;
use Support\Traits\HasModelUtilities;

/**
 * Class CustomFormsShow
 *
 * @property int $form_id
 * @property int $show_on
 * @property int $show_for
 * @property int $show_count
 * @property int $rank
 *
 * @property CustomForm $custom_form
 *
 * @package Domain\CustomForms\Models
 */
class FormShow extends Model
{
    use HasModelUtilities;
    public $incrementing = false;
    public $timestamps = false;
    protected $table = 'custom_forms_show';

    protected $casts = [
        'form_id' => 'int',
        'show_on' => 'int',
        'show_for' => 'int',
        'show_count' => 'int',
        'rank' => 'int',
    ];

    protected $fillable = [
        'form_id',
        'show_on',
        'show_for',
        'show_count',
        'rank',
    ];

    public function form()
    {
        return $this->belongsTo(CustomForm::class, 'form_id');
    }
}
