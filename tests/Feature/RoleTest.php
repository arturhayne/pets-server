<?php

namespace Tests\Unit;

use Tests\TestCase;

class RoleTest extends TestCase
{
    /**
     * Test api to load roles
     */
    public function testApiLoad()
    {
        $response = $this->get($this->apiPath . '/roles', $this->createAuthHeaderToNormalUser());

        $response->assertStatus(200);
        $this->seeJsonStructure($response, [
            '*' => [
                'id', 'slug', 'title'
            ]
        ]);

        //need to be at least admin
        $this->assertGreaterThanOrEqual(count($response->decodeResponseJson()), 1);
    }
}
