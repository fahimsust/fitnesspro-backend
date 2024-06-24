<?php

namespace App\Api\Admin\Accounts\Controllers;

use Domain\Accounts\Actions\LoadAccountByIdFromCache;
use Domain\Messaging\Models\MessageTemplate;
use Domain\Sites\Actions\LoadSiteByIdFromCache;
use Illuminate\Http\Request;
use Support\Controllers\AbstractController;
use Support\Helpers\HandleMessageKeys;

class AccountMessageTemplateController extends AbstractController
{
    public function index(Request $request)
    {
        return MessageTemplate::select('id', 'name', 'subject')
            ->get()
            ->toArray();
    }

    public function store(Request $request)
    {
        $messageTemplate = MessageTemplate::find($request->message_template_id);

        $messageTemplate->replaceKeysUsingHandler(
            (new HandleMessageKeys())
                ->setSite(
                    LoadSiteByIdFromCache::now($request->site_id)
                )
                ->setAccount(
                    LoadAccountByIdFromCache::now($request->account_id)
                )
        );

        return [
            'subject' => $messageTemplate->subject,
            'content' => $messageTemplate->html_body,
        ];
    }
}
