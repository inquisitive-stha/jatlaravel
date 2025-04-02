<?php

use Modules\Company\Models\Company;

use function Pest\Laravel\get;

it('list companies', function () {

    loginAsUser();

    $company = Company::factory()->create();

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
                        'created_at',
                        'updated_at'
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

    $response = $this->postJson('/api/v1/companies', [
        'name' => $company->name,
        'slug' => $company->slug,
        'location' => $company->location,
        'job_post_url' => $company->job_post_url,
        'status' => $company->status,
    ]);

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
                    'created_at',
                    'updated_at'
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

});
