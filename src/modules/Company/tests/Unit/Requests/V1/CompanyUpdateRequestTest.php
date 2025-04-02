<?php

use Modules\Company\Models\Company;

it('validates update field only if present', function() {

    loginAsUser();

    $company = Company::factory()->create();

    $response = $this->patchJson("/api/v1/companies/{$company->id}", [
        'data' => [
            'attributes' => [
                'name' => '',
                'location' => '',
            ]
        ]
    ]);

    $response->assertStatus(200)
        ->assertJsonStructure([
            'errors' => [
                '*' => [
                    'status',
                    'message',
                    'source'
                ]
            ]
        ])
        ->assertJsonFragment([
            'status' => 422,
            'source' => 'data.attributes.name'
        ])
        ->assertJsonFragment([
            'status' => 422,
            'source' => 'data.attributes.location'
        ]);

});
