<?php

namespace App\Api\Admin\Accounts\Controllers;

use App\Api\Admin\Accounts\Requests\AccountCertificationRequest;
use App\Api\Admin\Accounts\Requests\UpdateCertificationRequest;
use Domain\Accounts\Actions\CreateCertificate;
use Domain\Accounts\Actions\DeleteCertificate;
use Domain\Accounts\Actions\UpdateCertificate;
use Domain\Accounts\Models\Certifications\Certification;
use Illuminate\Http\Request;
use Support\Controllers\AbstractController;
use Symfony\Component\HttpFoundation\Response;

class AccountCertificationController extends AbstractController
{
    public function index(Request $request)
    {
        return response(
            Certification::orderBy('id', 'DESC')
                ->limit(100)
                ->where('account_id', $request->account_id)
                ->get(),
            Response::HTTP_OK
        );
    }
    public function store(AccountCertificationRequest $request)
    {
        return response(
            CreateCertificate::run($request),
            Response::HTTP_CREATED
        );
    }
    public function update(Certification $accountCertification, UpdateCertificationRequest $request)
    {
        return response(
            UpdateCertificate::run($accountCertification, $request),
            Response::HTTP_CREATED
        );
    }
    public function destroy(Certification $accountCertification)
    {
        return response(
            DeleteCertificate::run($accountCertification),
            Response::HTTP_OK
        );
    }
}
