<?php

use Modules\Company\Models\Company;

it('list companies', function () {

    loginAsUser();

    Company::factory()->create();

    $response = $this->getJson('/api/v1/companies');

    // assert the response
    $response->assertStatus(200)
        ->assertJsonStructure([
            'data' => [
                '*' => [
                    'type',
                    'id',
                    'attributes' => [
                        'name',
                        'slug',
                        'location',
                        'createdAt',
                        'updatedAt'
                    ],
                    'relationships' => [
                        'user' => [
                            'data' => [
                                'type',
                                'id'
                            ],
                            'links' => [
                                'self'
                            ]
                        ]
                    ],
                    'links' => [
                        'self'
                    ]
                ]
            ]
        ])
        ->assertJsonCount(1, 'data');

});

it('store company', function(){
    loginAsUser();

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
    $response->assertStatus(201)
        ->assertJsonStructure([
            'data' => [
                'type',
                'id',
                'attributes' => [
                    'name',
                    'slug',
                    'location',
                    'createdAt',
                    'updatedAt'
                ],
                'relationships' => [
                    'user' => [
                        'data' => [
                            'type',
                            'id'
                        ],
                        'links' => [
                            'self'
                        ]
                    ]
                ],
                'links' => [
                    'self'
                ]
            ]
        ]);

    $this->assertDatabaseHas('companies', [
        'name' => $company->name,
        'location' => $company->location,
    ]);

    //verify name, location and user_id is same on response
    $this->assertEquals($company->name, $response->json('data.attributes.name'));
    $this->assertEquals($company->location, $response->json('data.attributes.location'));
    $this->assertEquals(auth()->user()->id, $response->json('data.relationships.user.data.id'));

});

it('show company', function () {
    $actingUser = loginAsUser();

    $company = Company::factory()->create([
        'user_id' => $actingUser->id,
    ]);

    $response = $this->getJson('/api/v1/companies/' . $company->id);

    // assert the response
    $response->assertStatus(200)
        ->assertJsonStructure([
            'data' => [
                'type',
                'id',
                'attributes' => [
                    'name',
                    'slug',
                    'location',
                    'createdAt',
                    'updatedAt'
                ],
                'relationships' => [
                    'user' => [
                        'data' => [
                            'type',
                            'id'
                        ],
                        'links' => [
                            'self'
                        ]
                    ]
                ],
                'links' => [
                    'self'
                ]
            ]
        ]);

    //get acting as user id

    //verify name, location and user_id is same on response
    $this->assertEquals($company->name, $response->json('data.attributes.name'));
    $this->assertEquals($company->location, $response->json('data.attributes.location'));
    $this->assertEquals($actingUser->id, $response->json('data.relationships.user.data.id'));
});

it('update company', function () {
    loginAsUser();

    $company = Company::factory()->create();

    $data = [
        'data' => [
            'attributes' => [
                'name' => 'Updated Name',
                'location' => 'Updated Location',
            ],
        ]
    ];

    $response = $this->putJson('/api/v1/companies/' . $company->id, $data);

    // assert the response
    $response->assertStatus(200)
        ->assertJsonStructure([
            'data' => [
                'type',
                'id',
                'attributes' => [
                    'name',
                    'slug',
                    'location',
                    'createdAt',
                    'updatedAt'
                ],
                'relationships' => [
                    'user' => [
                        'data' => [
                            'type',
                            'id'
                        ],
                        'links' => [
                            'self'
                        ]
                    ]
                ],
                'links' => [
                    'self'
                ]
            ]
        ]);

    //verify name, location and user_id is same on response
    $this->assertEquals($data['data']['attributes']['name'], $response->json('data.attributes.name'));
    $this->assertEquals($data['data']['attributes']['location'], $response->json('data.attributes.location'));
});

it('delete company', function () {
    loginAsUser();

    $company = Company::factory()->create();

    $response = $this->deleteJson('/api/v1/companies/' . $company->id);

    // assert the response
    $response->assertStatus(200);

    // verify the company is deleted
    $this->assertDatabaseMissing('companies', [
        'id' => $company->id,
    ]);
});
