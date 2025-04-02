<?php

use App\Http\Resources\UserResource;
use Modules\Company\Http\Resources\V1\CompanyResource;
use Modules\Company\Models\Company;

it('returns expected json structure', function(){

    $actingUser = loginAsUser();

    $company = Company::factory()->create([
        'user_id' => $actingUser->id,
    ])->load('user');

    $response = new CompanyResource($company);

    $this->assertEquals($response->toArray(request()), [
        'type' => 'company',
        'id' => $company->id,
        'attributes' => [
            'name' => $company->name,
            'slug' => $company->slug,
            'location' => $company->location,
            'createdAt' => $company->created_at,
            'updatedAt' => $company->updated_at,
        ],
        'relationships' => [
            'user' => [
                'data' => [
                    'type' => 'user',
                    'id' => $actingUser->id,
                ],
                'links' => [
                    'self' => route('api.v1.users.show', ['user' => $actingUser->id]),
                ],
            ],
        ],
        'includes' => new UserResource($company->user),
        'links' => [
            'self' => route('api.v1.companies.show', ['company' => $company->id]),
        ],
    ]);

});

it('will not load user relationship if user is not eager loaded', function(){

    $actingUser = loginAsUser();

    $company = Company::factory()->create([
        'user_id' => $actingUser->id,
    ])->unsetRelation('user');

    $response = new CompanyResource($company);

    //just confirming that the user relationship is not loaded
    $this->assertNull($response->includes);

});
