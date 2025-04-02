<?php

use Modules\Company\Models\Company;

it('creates company with valid data', function (){
    loginAsUser();

    $company = Company::factory()->make();
    $payload['data']['attributes'] = [
        'name' => $company->name,
        'location' => $company->location,
    ];
    $response = $this->postJson('/api/v1/companies', $payload);

    $this->assertDatabaseHas('companies', [
        'name' => $company->name,
        'location' => $company->location,
    ]);

    // assert the response
    $response->assertStatus(201);

});

it('generates slug from name', function (){
   loginAsUser();

    $company = Company::factory()->make();
    $payload['data']['attributes'] = [
        'name' => $company->name,
        'location' => $company->location,
    ];

    $response = $this->postJson('/api/v1/companies', $payload);

    // assert the response
    $response->assertStatus(201)
        ->assertJsonFragment([
            'slug' => \Illuminate\Support\Str::slug($company->name, '-')
        ]);

});

it('assigns current users to company', function (){
   $actingUser = loginAsUser();

    $company = Company::factory()->make();

    $data = [
        'data' => [
            'attributes' => [
                'name' => $company->name,
                'location' => $company->location,
            ],
        ]
    ];
    $response = $this->postJson('/api/v1/companies', $data);

    // assert the response
    $response->assertStatus(201);

    $this->assertDatabaseHas('companies', [
        'name' => $company->name,
        'location' => $company->location,
        'user_id' => $actingUser->id,
    ]);

    $this->assertEquals($actingUser->id, $response->json('data.relationships.user.data.id'));

});

