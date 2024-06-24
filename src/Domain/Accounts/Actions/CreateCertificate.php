<?php

namespace Domain\Accounts\Actions;

use App\Api\Admin\Accounts\Requests\AccountCertificationRequest;
use Domain\Accounts\Models\Certifications\Certification;
use Lorisleiva\Actions\Concerns\AsObject;

class CreateCertificate
{
    use AsObject;

    public function handle(AccountCertificationRequest $request): Certification
    {
        $filePath = null;

        if ($request->hasFile('file_name')) {
            $file = $request->file('file_name');
            $filePath = $file->store('certificates', 's3');
        }

        return Certification::create([
            'account_id' => $request->account_id,
            'cert_num' => $request->cert_num,
            'cert_type' => $request->cert_type,
            'cert_org' => $request->cert_org,
            'file_name' => $filePath, // Store the file path in S3
            'approval_status' => $request->approval_status,
            'cert_exp' => $request->cert_exp,
            'created' => now()
        ]);
    }
}
