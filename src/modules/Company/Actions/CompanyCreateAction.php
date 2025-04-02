<?php

namespace Modules\Company\Actions;

use Modules\Company\DTO\CompanyCreateActionDTO;
use Modules\Company\Models\Company;

class CompanyCreateAction
{
    public function execute(CompanyCreateActionDTO $dto)
    {
        return Company::query()->create(collect($dto)->toArray());
    }
}
