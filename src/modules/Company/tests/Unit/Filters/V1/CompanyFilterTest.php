<?php

use Modules\Company\Http\Filters\V1\CompanyFilter;
use Modules\Company\Models\Company;
use Illuminate\Http\Request;

beforeEach(function () {
    $this->company1 = Company::factory()->create(['name' => 'First Company', 'slug' => 'first-company', 'location' => 'First Location']);
    $this->company2 = Company::factory()->create(['name' => 'Second Company', 'location' => 'Second Place']);
});

it('can filter by exact and wildcard', function (array $filterData) {
    $request = new Request($filterData);
    $filter = new CompanyFilter($request);

    $filteredCompanies = Company::filter($filter)->get();

    expect($filteredCompanies)->toHaveCount(1)
        ->and($filteredCompanies->first()->id)->toEqual($this->company1->id);
})->with([
    'exactId' => [['id' => 1]],
    'exactName' => [['name' => 'First Company']],
    'wildcardName' => [['name' => 'First*']],
    'wildcardLocation' => [['location' => '*Location*']],
    'wildcardSlug' => [['slug' => 'first*']],
]);

it('can sort by name and location asc ', function (array $filterData) {
    $request = new Request($filterData);
    $filter = new CompanyFilter($request);

    $sortedCompanies = Company::filter($filter)->get();

    expect($sortedCompanies->first()->id)->toEqual($this->company1->id);
})->with([
    'sortByName' => [['sort' => 'name']],
    'sortByLocation' => [['sort' => 'location']],
]);

it('can sort by name and location desc ', function (array $filterData) {
    $request = new Request($filterData);
    $filter = new CompanyFilter($request);

    $sortedCompanies = Company::filter($filter)->get();

    expect($sortedCompanies->first()->id)->toEqual($this->company2->id);
})->with([
    'sortByName' => [['sort' => '-name']],
    'sortByLocation' => [['sort' => '-location']],
]);


