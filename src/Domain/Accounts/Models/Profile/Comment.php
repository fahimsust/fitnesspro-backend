<?php

namespace Domain\Accounts\Models\Profile;

use Domain\Accounts\Models\Account;
use Illuminate\Database\Eloquent\Model;

class Comment extends Model
{
    public $timestamps = false;
    protected $table = 'accounts_comments';

    protected $casts = [
        'account_id' => 'int',
        'createdby' => 'int',
        'beenread' => 'bool',
        'replyto_id' => 'int',
        'created' => 'datetime',
    ];

    protected $fillable = [
        'account_id',
        'body',
        'created',
        'createdby',
        'beenread',
        'replyto_id',
    ];

    public function subject()
    {
        return $this->belongsTo(Account::class, 'replyto_id');
    }

    public function author()
    {
        //todo create fk
        return $this->belongsTo(Account::class, 'createdby');
    }

    public function replyTo()
    {
        return $this->hasMany(static::class, 'replyto_id');
    }
}
