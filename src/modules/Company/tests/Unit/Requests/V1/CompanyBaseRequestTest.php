<?php

use Modules\Company\Http\Requests\V1\CompanyBaseRequest;

it('correctly maps request attributes', function(){

    $actingUser = loginAsUser();

    $request = new CompanyBaseRequest([
        'data' => [
            'attributes' => [
                'name' => 'Test Company',
                'location' => 'Test Location',
                'createdAt' => '2010-01-01 00:00:00',
                'updatedAt' => '2010-01-02 00:00:00',
            ],
            'relationships' => [
                'user' => [
                    'data' => [
                        'id' => $actingUser->id,
                    ]
                ]
            ]
        ]
    ]);

    $mappedAttributes = $request->mappedAttributes();

    expect($mappedAttributes)->toBe([
        'name' => 'Test Company',
        'location' => 'Test Location',
        'created_at' => '2010-01-01 00:00:00',
        'updated_at' => '2010-01-02 00:00:00',
        'user_id' => $actingUser->id,
    ]);

});
