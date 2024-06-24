<?php

namespace Domain\Messaging\Models;

use Domain\Accounts\Models\MessageTemplateSentToAccount;
use Domain\AdminUsers\Models\AdminEmailsSent;
use Domain\Messaging\QueryBuilders\MessageTemplateQuery;
use Domain\Orders\Models\Order\OrderItems\OrderItemSentEmail;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Support\Helpers\HandleMessageKeys;
use Support\Traits\HasModelUtilities;

class MessageTemplate extends Model
{
    use HasFactory,
        HasModelUtilities;

    protected $guarded = ['id'];

    protected $hidden = ['notes'];

    protected $fillable = [
        'name',
        'subject',
        'alt_body',
        'html_body',
        'note',
        'system_id',
    ];

    public function newEloquentBuilder($query)
    {
        return new MessageTemplateQuery($query);
    }

    public function getHtmlAttribute()
    {
        return $this->normalizeLineBreaks(
            htmlspecialchars_decode($this->html_body)
        );
    }

    public function getPlainTextAttribute()
    {
        return $this->normalizeLineBreaks($this->alt_body);
    }

    public static function FindBySystemId($systemId): MessageTemplate
    {
        return self::whereSystemId($systemId)->first();
    }

    public function replaceKeysUsingHandler(HandleMessageKeys $keyHandler): MessageTemplate
    {
        //        $keys = new HandleMessageKeys(['SYSTEM_ADMIN_URL' => SYSTEM_ADMIN_URL]); //Your previous codebase
        //        $keys = new HandleMessageKeys($data);
        //        $this->plain_text = $keys->replaceAll($this->plain_text); //Conflict of Getter during response in your previous codebase
        $this->alt_body = $keyHandler->replaceAll($this->alt_body);
        $this->html_body = $keyHandler->replaceAll($this->html_body);
        $this->subject = $keyHandler->replaceAll($this->subject);

        return $this;
    }

    public function sentToAccount()
    {
        return $this->hasOne(
            MessageTemplateSentToAccount::class,
            'template_id'
        );
    }

    public function sentByAdmin()
    {
        return $this->hasMany(
            AdminEmailsSent::class,
            'template_id'
        );
    }
    public function category()
    {
        return $this->belongsTo(MessageTemplateCategory::class);
    }

    //    public function autoEmails()
    //    {
    //        return $this->hasMany(AutoEmail::class);
    //    }

    public function orderItemSentEmails()
    {
        return $this->hasMany(
            OrderItemSentEmail::class,
            'email_id'
        );
    }

    private function normalizeLineBreaks($content)
    {
        return str_replace('\r\n', "\r\n", $content);
    }

    //    public function mail($fromEmail, $fromName, $toEmail, $toName)
    //    {
    //        MultiMail::to($toEmail)->send([], [], function($message) use ($fromEmail, $fromName, $toEmail, $toName){
    //            $message->from($fromEmail, $fromName)
    //                ->to($toEmail, $toName)
    //                ->subject($this->subject)
    //                ->setBody($this->html, 'text/html')
    //                ->addPart($this->plain_text, 'text/plain');
    //        });
    //    }
    public function translations()
    {
        return $this->hasMany(
            MessageTemplateTranslation::class
        );
    }
}
