<?php

namespace Tests\RequestFactories\App\Api\Admin\Accounts\Requests;

use Domain\Accounts\Models\Account;
use Worksome\RequestFactories\RequestFactory;
use Illuminate\Http\UploadedFile;
use Illuminate\Support\Facades\Storage;

class AccountFileRequestFactory extends RequestFactory
{

    public function definition(): array
    {
        Storage::fake('local');
        $fakePdf = UploadedFile::fake()->create('document.pdf', 100);
        return [
            'account_id' => Account::firstOrFactory()->id,
            'filename' => $fakePdf,
        ];
    }
}
