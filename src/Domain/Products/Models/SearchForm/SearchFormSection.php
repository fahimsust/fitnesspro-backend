<?php

namespace Domain\Products\Models\SearchForm;

use Illuminate\Database\Eloquent\Model;

/**
 * Class SearchFormsSection
 *
 * @property int $id
 * @property int $form_id
 * @property string $title
 * @property int $rank
 *
 * @property SearchForm $search_form
 *
 * @package Domain\Products\Models\SearchForm
 */
class SearchFormSection extends Model
{
    public $timestamps = false;
    protected $table = 'search_forms_sections';

    protected $casts = [
        'form_id' => 'int',
        'rank' => 'int',
    ];

    protected $fillable = [
        'form_id',
        'title',
        'rank',
    ];

    public function form()
    {
        return $this->belongsTo(SearchForm::class, 'form_id');
    }

    public function fields()
    {
        //todo
        return $this->hasManyThrough(
            SearchFormField::class,
            SearchFormSectionField::class,
        );
    }
}
