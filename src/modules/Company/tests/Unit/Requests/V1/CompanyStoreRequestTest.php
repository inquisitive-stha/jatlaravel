<?php

it('validates required field for store', function() {

    loginAsUser();
    $response = $this->postJson('/api/v1/companies', []);

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
            'message' => 'The data.attributes.name field is required.',
            'source' => 'data.attributes.name'
        ])
        ->assertJsonFragment([
            'status' => 422,
            'message' => 'The data.attributes.location field is required.',
            'source' => 'data.attributes.location'
        ]);

});
