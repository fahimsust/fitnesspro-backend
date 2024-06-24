<?php

namespace Tests\RequestFactories\App\Api\Admin\Accounts\Requests;

use Domain\Accounts\Models\Account;
use Worksome\RequestFactories\RequestFactory;
use Illuminate\Http\UploadedFile;
use Illuminate\Support\Facades\Storage;
use Carbon\Carbon;

class UpdateCertificationRequestFactory extends RequestFactory
{

    public function definition(): array
    {
        Storage::fake('local');
        $fakePdf = UploadedFile::fake()->create('document.pdf', 100);
        $faker = $this->faker;
        $exp_date = Carbon::now()->addDays(28);
        return [
            'cert_num' => $faker->regexify('[A-Za-z0-9]{10}'),
            'cert_type' => substr($faker->word, 0, 55),
            'cert_org' => substr($faker->company, 0, 55),
            'file_name' => $fakePdf,
            'approval_status' => $faker->boolean,
            'cert_exp' => $exp_date
        ];
    }
}
