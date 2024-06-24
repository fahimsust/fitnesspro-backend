<?php

namespace App\Api\Admin\Accounts\Controllers;

use App\Api\Admin\Accounts\Requests\AccountCertificationRequest;
use App\Api\Admin\Accounts\Requests\AccountFileRequest;
use App\Api\Admin\Accounts\Requests\UpdateCertificationRequest;
use Domain\Accounts\Actions\CreateCertificate;
use Domain\Accounts\Actions\DeleteAccountFile;
use Domain\Accounts\Actions\DeleteCertificate;
use Domain\Accounts\Actions\UpdateCertificate;
use Domain\Accounts\Actions\UploadAccountFile;
use Domain\Accounts\Models\AccountFile;
use Domain\Accounts\Models\Certifications\Certification;
use Illuminate\Http\Request;
use Support\Controllers\AbstractController;
use Symfony\Component\HttpFoundation\Response;

class AccountFileController extends AbstractController
{
    public function index(Request $request)
    {
        return response(
            AccountFile::orderBy('id', 'DESC')
                ->limit(100)
                ->where('account_id', $request->account_id)
                ->get(),
            Response::HTTP_OK
        );
    }
    public function store(AccountFileRequest $request)
    {
        return response(
            UploadAccountFile::run($request),
            Response::HTTP_CREATED
        );
    }
    public function destroy(AccountFile $accountFile)
    {
        return response(
            DeleteAccountFile::run($accountFile),
            Response::HTTP_OK
        );
    }
}
