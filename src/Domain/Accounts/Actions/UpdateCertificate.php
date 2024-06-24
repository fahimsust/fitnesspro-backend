<?php

namespace Domain\Accounts\Actions;

use App\Api\Admin\Accounts\Requests\AccountCertificationRequest;
use App\Api\Admin\Accounts\Requests\UpdateCertificationRequest;
use Domain\Accounts\Models\Certifications\Certification;
use Lorisleiva\Actions\Concerns\AsObject;
use Illuminate\Support\Facades\Storage;

class UpdateCertificate
{
    use AsObject;

    public function handle(Certification $certification, UpdateCertificationRequest $request): Certification
    {
        if ($request->hasFile('file_name')) {
            // Delete the old file from storage if it exists.
            if ($certification->file_name) {
                Storage::disk('s3')->delete($certification->file_name);
            }

            $file = $request->file('file_name');
            $filePath = $file->store('certificates', 's3');
            $certification->file_name = $filePath;
        }

        // Update other fields
        $certification->cert_num = $request->cert_num;
        $certification->cert_type = $request->cert_type;
        $certification->cert_org = $request->cert_org;
        $certification->approval_status = $request->approval_status;
        $certification->cert_exp = $request->cert_exp;
        $certification->updated = now();

        // Save the updated certification
        $certification->save();

        return $certification;
    }
}
