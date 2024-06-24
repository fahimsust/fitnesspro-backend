<?php

namespace Domain\Events\Models;

use Carbon\Carbon;
use Domain\Accounts\Models\Account;
use Domain\Locales\Models\Country;
use Domain\Locales\Models\StateProvince;
use Domain\Photos\Models\Photo;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Support\Traits\HasModelUtilities;

class Event extends Model
{
    use HasFactory,
        HasModelUtilities;

    protected $table = 'events';

    protected $guarded = ['id'];

    protected $hidden = [
        'sdate', 'edate',
    ];

    protected $appends = [
        'start_date',
        'end_date',
    ];

//    public function format(){
//        return [
//            'id' =>$this->id,
//            'title' => $this->title,
//            'description' => $this->word,
//            'sdate' => $this->sdate,
//            'edate' => $this->edate,
//            'timezone' => $this->timezone,
//            'created' => $this->created,
//            'createdby' => $this->account,
//            'photo' => $this->photo,
//            'type' => $this->type,
//            'type_id' => $this->event_type,
//            'city' => $this->city,
//            'state' => $this->state_,
//            'country' => $this->country_,
//            'webaddress' => $this->url,
//            'email' => $this->email,
//            'phone' => $this->phone
//        ];
//    }

    public function getEndDateAttribute()
    {
        return $this->edate;
    }

    public function getStartDateAttribute()
    {
        return $this->sdate;
    }

    public function scopeFuture($query)
    {
        return $query->where('sdate', '>=', Carbon::now());
    }

    public function scopeStartDate($query, $startDate)
    {
        return $query->where('sdate', '=', $startDate);
    }

    public function scopeEndDate($query, $endDate)
    {
        return $query->where('edate', '=', $endDate);
    }

    public function scopeTitle($query, $title)
    {
        return $query->where('title', 'like', '%'.$title.'%');
    }

    public function scopeAccountEmail($query, $data = null)
    {
        return $query->whereHas('account', function ($q) use ($data) {
            return $q->where('email', 'like', '%'.$data['email'].'%');
        });
    }

//    public function scopeSearchAccountFirstNameANDLastName($query, $data=null){
//        return $query->whereHas('account', function($q) use($data){
//            return $q->where('first_name', 'like', '%'.$data['first_name'].'%')
//                ->where('last_name', 'like', '%'.$data['last_name'].'%');
//        });
//    }

    public function account()
    {
        return $this->belongsTo(Account::class, 'createdby', 'id');
    }

    public function country()
    {
        return $this->belongsTo(Country::class, 'country', 'abbreviation');
    }

    public function state()
    {
        return $this->belongsTo(StateProvince::class, 'state', 'abbreviation');
    }

    public function photo()
    {
        return $this->belongsTo(Photo::class, 'photo');
    }

    public function accountsAttending()
    {
        //todo
        return $this->hasManyThrough(
            Account::class,
            EventAttendee::class,
            'eventid'
        );
    }

    public function views()
    {
        return $this->hasMany(EventView::class);
    }
}
