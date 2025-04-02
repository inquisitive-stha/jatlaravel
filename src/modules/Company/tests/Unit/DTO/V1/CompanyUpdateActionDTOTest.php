<?php

use Modules\Company\DTO\V1\CompanyUpdateActionDTO;
use Modules\Company\Models\Company;


it('only maps data which are provided for update action', function (array $payload) {
    $actingUser = loginAsUser();

    Company::factory()->create([
        'name' => 'Test Company',
        'location' => 'Test Location',
        'user_id' => $actingUser->id,
    ]);

    $companyDTO = new CompanyUpdateActionDTO($payload);

    if(!isset($payload['name'])) {
        expect(!isset($companyDTO->name))->toBeTrue();
    }

    if(!isset($payload['location'])) {
        expect(!isset($companyDTO->location))->toBeTrue();
    }

})->with([
    'withNameOnly' => [['name' => 'New Name']],
    'withLocationOnly' => [['location' => 'New Location']],
]);
