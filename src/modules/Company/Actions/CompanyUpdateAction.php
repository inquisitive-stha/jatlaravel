<?php

namespace Modules\Company\Actions;

use Modules\Company\DTO\CompanyCreateActionDTO;
use Modules\Company\DTO\CompanyUpdateActionDTO;
use Modules\Company\Models\Company;

class CompanyUpdateAction
{
    public function execute(CompanyUpdateActionDTO $dto, Company|int $company)
    {
        if(!$company instanceof Company) {
            $company = Company::query()->findOrFail($company);
        }
        $company->update(collect($dto)->toArray());
        return $company;
    }
}
