<?php

namespace Domain\Products\Models\SearchForm;

use Domain\Content\Models\Element;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Support\Traits\HasModelUtilities;

/**
 * Class SearchFormsField
 *
 * @property int $id
 * @property string $display
 * @property int $type
 * @property bool $search_type
 * @property int $search_id
 * @property int $rank
 * @property string $cssclass
 * @property bool $status
 * @property int $help_element_id
 *
 * @property SearchForm $search_form
 * @property SearchFormSectionField $search_forms_sections_field
 *
 * @package Domain\Products\Models\SearchForm
 */
class SearchFormField extends Model
{
    use HasFactory,
        HasModelUtilities;
    protected $table = 'search_forms_fields';

    protected $casts = [
        'type' => 'int',
        'search_type' => 'bool',
        'search_id' => 'int',
        'rank' => 'int',
        'status' => 'bool',
        'help_element_id' => 'int',
    ];

    public function form()
    {
        return $this->belongsTo(SearchForm::class, 'search_id');
    }
    public function element()
    {
        return $this->belongsTo(Element::class, 'help_element_id');
    }

    public function sections()
    {
        //todo
        return $this->hasManyThrough(
            SearchFormSection::class,
            SearchFormSectionField::class,
            'field_id'
        );
    }
}
