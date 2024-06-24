<?php

namespace App\Api\Admin\Accounts\Controllers;

use App\Api\Admin\Accounts\Requests\AccountSpecialtyRequest;
use Domain\Accounts\Models\AccountSpecialty;
use Domain\Accounts\Models\Specialty;
use Illuminate\Http\Request;
use Support\Controllers\AbstractController;
use Symfony\Component\HttpFoundation\Response;

class AccountSpecialtyController extends AbstractController
{
    public function index(Request $request)
    {
        $accountId = $request->account_id;

        $specialties = Specialty::whereNull('parent_id')
            ->with(['childrenRecursive', 'accountSpecialties'])
            ->get();

        $specialties = $this->transFromData($specialties, $accountId);
        return response(
            $specialties,
            Response::HTTP_OK
        );
    }
    public function store(AccountSpecialtyRequest $request)
    {
        $accountSpecialty = AccountSpecialty::firstOrNew([
            'account_id' => $request->account_id,
            'specialty_id' => $request->specialty_id
        ]);

        $accountSpecialty->approved = $request->approved;

        // Save the changes
        $accountSpecialty->save();

        return response(
            $accountSpecialty->refresh(),
            Response::HTTP_CREATED
        );
    }
    public function destroy(AccountSpecialty $accountSpecialty)
    {
        return response(
            $accountSpecialty->delete(),
            Response::HTTP_OK
        );
    }

    private function transFromData($specialties, $accountId)
    {
        $specialties->transform(function ($specialty) use ($accountId) {
            $specialtyAttributes = $specialty->getAccountSpecialty($accountId);
            $specialty->account_specialty = $specialtyAttributes;
            if ($specialty->childrenRecursive) {
                $children = $this->transFromData($specialty->childrenRecursive, $accountId);
                $specialty->childrenRecursive = $children;
            }
            return $specialty;
        });

        return $specialties;
    }
}
