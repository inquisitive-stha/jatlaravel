<?php

use Modules\Company\DTO\V1\CompanyUpdateActionDTO;
use Modules\Company\Models\Company;

beforeEach(function () {
    $this->companyUpdateAction = app(\Modules\Company\Actions\CompanyUpdateAction::class);
});

it('updates company with valid data', function ($company) {

    loginAsUser($company->user);

    $newCompany = Company::factory()->make();

    $this->companyUpdateAction->execute(new CompanyUpdateActionDTO([
        'name' => $newCompany->name,
        'location' => $newCompany->location,
        'user_id' => $company->user_id,
    ]), $company);

    $this->assertDatabaseHas('companies', [
        'name' => $newCompany->name,
        'location' => $newCompany->location,
    ]);

})->with([
    fn() => Company::factory()->create(),
]);

it('updates slug when name changes', function ($company) {

    loginAsUser($company->user);

    $newCompany = Company::factory()->make();

    $this->companyUpdateAction->execute(new CompanyUpdateActionDTO([
        'name' => $newCompany->name,
        'location' => $newCompany->location,
        'user_id' => $company->user_id,
    ]), $company);

    $this->assertDatabaseHas('companies', [
        'name' => $newCompany->name,
        'location' => $newCompany->location,
    ]);

})->with([
    fn() => Company::factory()->create(),
]);

it('preserve unchanged fields', function ($company) {

    loginAsUser($company->user);

    $newCompany = Company::factory()->make();

    $this->companyUpdateAction->execute(new CompanyUpdateActionDTO([
        'location' => $newCompany->location,
    ]), $company);

    $this->assertDatabaseHas('companies', [
        'name' => $company->name,
        'location' => $newCompany->location,
    ]);

})->with([
    fn() => Company::factory()->create(),
]);
