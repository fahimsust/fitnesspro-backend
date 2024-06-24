<?php

namespace App\Api\Admin\Speciality\Controllers;

use App\Api\Admin\Speciality\Requests\SpecialitySearchRequest;
use Domain\Accounts\Models\Specialty;
use Support\Controllers\AbstractController;
use Symfony\Component\HttpFoundation\Response;

class AllSpecialityController extends AbstractController
{
    public function __invoke(SpecialitySearchRequest $request)
    {
        $specialities = Specialty::whereNull('parent_id')->with('children.children')->orderBy('name','asc')->select(['name','id'])->get();
        return response(
            $this->buildHierarchy($specialities),
            Response::HTTP_OK
        );
    }
    private function buildHierarchy($specialities, $parentName = '')
    {
        $result = [];

        foreach ($specialities as $speciality) {
            $fullName = $parentName ? $parentName . ' :: ' . $speciality->name : $speciality->name;
            $result[] = [
                'id' => $speciality->id,
                'name' => $fullName,
            ];

            if ($speciality->children->isNotEmpty()) {
                $result = array_merge($result, $this->buildHierarchy($speciality->children, $fullName));
            }
        }

        return $result;
    }
}
