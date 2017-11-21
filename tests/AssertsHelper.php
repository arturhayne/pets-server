<?php

namespace Tests;

use Illuminate\Foundation\Testing\TestResponse;

trait AssertsHelper
{
    /**
     * Assert that the JSON response has a given structure.
     *
     * @param  array|null  $structure
     * @param  array|null  $responseData
     * @return $this
     */
    public function seeJsonStructure(TestResponse $response, array $structure = null, $responseData = null)
    {
        if (is_null($structure)) {
            throw new Exception('A structure must be informed');
        }

        if (is_null($responseData)) {
            $responseData = $response->decodeResponseJson();
        }

        foreach ($structure as $key => $value) {
            if (is_array($value) && $key === '*') {
                $this->assertInternalType('array', $responseData);

                foreach ($responseData as $responseDataItem) {
                    $this->seeJsonStructure($response, $structure['*'], $responseDataItem);
                }
            } elseif (is_array($value)) {
                $this->assertArrayHasKey($key, $responseData);
                $this->seeJsonStructure($response, $structure[$key], $responseData[$key]);
            } else {
                $this->assertArrayHasKey($value, $responseData);
            }
        }

        return $this;
    }
}
