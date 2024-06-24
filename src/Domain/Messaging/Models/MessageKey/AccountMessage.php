<?php

namespace Domain\Messaging\Models\MessageKey;

use Domain\Accounts\Models\Account;
use Illuminate\Database\Eloquent\Model;

class AccountMessage extends Model
{
    public $timestamps = false;
    protected $table = 'accounts_messages';

    protected $casts = [
        'header_id' => 'int',
        'replied_id' => 'int',
        'to_id' => 'int',
        'from_id' => 'int',
        'status' => 'bool',
        'beenseen' => 'bool',
        'sent' => 'datetime',
        'readdate' => 'datetime',
    ];

    protected $fillable = [
        'header_id',
        'replied_id',
        'to_id',
        'from_id',
        'body',
        'sent',
        'readdate',
        'status',
        'beenseen',
    ];

    public function sender()
    {
        return $this->belongsTo(
            Account::class,
            'from_id',
        );
    }

    public function recipient()
    {
        return $this->belongsTo(
            Account::class,
            'to_id'
        );
    }

    public function header()
    {
        return $this->belongsTo(
            AccountMessageHeader::class,
            'header_id'
        );
    }

    public function replyTo()
    {
        return $this->belongsTo(
            AccountMessage::class,
            'replied_id'
        );
    }
}
