<?php

namespace Tests\Unit;

use Tests\TestCase;

class AuditTest extends TestCase
{
    /**
     * Test api load models
     */
    public function testApiLoadModels()
    {
        $response = $this->get($this->apiPath . '/audit/models', $this->createAuthHeaderToAdminUser());
        $response->assertStatus(200);

        $this->seeJsonStructure($response, ['models']);
        //need to be at least user model
        $this->assertContains('User', $response->decodeResponseJson()['models']);
    }

    /**
     * Test api search
     */
    public function testApiSearch()
    {
        $header = $this->createAuthHeaderToAdminUser();

        //create and update a user to generate audit data
        $user = factory(\App\User::class)->states('rest')->make();
        $response = $this->post($this->apiPath . '/users', $user->getAttributes(), $header);

        $createdUser = $response->decodeResponseJson();
        $createdUser['name'] = 'Novo name AuditTest';
        $createdUser['email'] = '9u3h8912n3y82t37812yh3y812gt3@873189y371.com';

        $response = $this->put(
            $this->apiPath . '/users/' . $createdUser['id'],
            $createdUser,
            $header
        );

        $date = \Carbon::now()->timezone(config('app.timezone'))->format('Y-m-d H:i:sO');

        $query = [
            'user' => $this->adminUserData['name'],
            'model' => 'User',
            'auditable_id' => $createdUser['id'],
            'type' => 'updated',
            'dateStart' => $date,
            'dateEnd' => $date
        ];

        $response = $this->get($this->apiPath . '/audit?' . http_build_query($query), $header);
        $response->assertStatus(200);

        $responseData = $response->decodeResponseJson();

        $this->seeJsonStructure($response, [
            'total',
            'items' => [ '*' => [
                'id', 'type', 'auditable_id', 'auditable_type', 'created_at',
                'user_id',
                'old' => ['name', 'email'],
                'new' => ['name', 'email'],
                'user' => ['id', 'name']
            ]]
        ]);

        //create a laravel collection and collapse to remove index based
        $items = $responseData['items'];
        $items = collect($responseData['items']);

        // $this->assertEquals($createdUser['id'], $items->pluck('auditable_id')->first());
        $this->assertEquals($createdUser['name'], $items->pluck('new')->first()['name']);
        $this->assertEquals($createdUser['email'], $items->pluck('new')->first()['email']);
    }
}
