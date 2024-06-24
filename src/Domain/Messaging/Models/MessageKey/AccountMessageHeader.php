<?php

namespace Domain\Messaging\Models\MessageKey;

use Illuminate\Database\Eloquent\Model;

class AccountMessageHeader extends Model
{
    public $timestamps = false;
    protected $table = 'accounts_messages_headers';

    protected $fillable = [
        'subject',
    ];

    public function accounts_messages()
    {
        return $this->hasMany(AccountMessage::class, 'header_id');
    }
}
