<?php

namespace Domain\Locales\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class CountryIso extends Model
{
    use HasFactory;
    public $timestamps = false;
    protected $table = 'countries_iso';
}
