<?php

use Modules\Company\DTO\V1\CompanyCreateActionDTO;


it('correctly maps data to the CompanyDTO', function () {
    $actingUser = loginAsUser();
    $data = [
        'name' => 'Test Company',
        'slug' => 'test-company',
        'location' => 'Test Location',
        'user_id' => 1,
    ];

    $companyDTO = new CompanyCreateActionDTO($data);

    expect($companyDTO->name)->toBe('Test Company')
        ->and($companyDTO->slug)->toBe('test-company')
        ->and($companyDTO->location)->toBe('Test Location')
        ->and($companyDTO->user_id)->toBe($actingUser->id);
});

it('validates required fields', function (array $payload) {
    expect(fn() => new CompanyCreateActionDTO($payload))
        ->toThrow(\ErrorException::class);
})->with([
    'withoutName' => [['name' => '', 'location' => 'Test Location']],
    'withoutLocation' => [['name' => 'Test Name', 'location' => '']],
]);
