<?php

namespace Domain\Products\Models\SearchForm;

use Illuminate\Database\Eloquent\Model;

/**
 * Class SearchFormsSectionsField
 *
 * @property int $section_id
 * @property int $field_id
 * @property int $rank
 * @property bool $new_row
 *
 * @property SearchFormField $search_forms_field
 *
 * @package Domain\Products\Models\SearchForm
 */
class SearchFormSectionField extends Model
{
    public $incrementing = false;
    public $timestamps = false;
    protected $table = 'search_forms_sections_fields';

    protected $casts = [
        'section_id' => 'int',
        'field_id' => 'int',
        'rank' => 'int',
        'new_row' => 'bool',
    ];

    protected $fillable = [
        'section_id',
        'field_id',
        'rank',
        'new_row',
    ];

    public function section()
    {
        return $this->belongsTo(
            SearchFormSection::class,
            'section_id'
        );
    }

    public function field()
    {
        return $this->belongsTo(
            SearchFormField::class,
            'field_id'
        );
    }
}
