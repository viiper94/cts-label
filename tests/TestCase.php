<?php

namespace Tests;

use Illuminate\Foundation\Testing\TestCase as BaseTestCase;
use Illuminate\Support\Str;
use Illuminate\Testing\TestResponse;
use PHPUnit\Framework\Assert as PHPUnitAssert;
use Illuminate\Support\Arr;

abstract class TestCase extends BaseTestCase
{
    use CreatesApplication;

    protected function setUp(): void{
        parent::setUp();

        // Define the custom macro
        TestResponse::macro('assertJsonSeeInOrder', function (string $jsonResponse, string $contentKey,
                                                              array $expectedStrings, string $message = '') {
            $decodedResponse = json_decode($jsonResponse, true);

            PHPUnitAssert::assertIsArray($decodedResponse, 'The JSON response must be a valid JSON array.');

            $targetContent = $decodedResponse;
            if ($contentKey) {
                $contentKeyParts = explode('.', $contentKey);
                foreach ($contentKeyParts as $keyPart) {
                    if (!isset($targetContent[$keyPart])) {
                        PHPUnitAssert::fail("Missing key '$keyPart' in JSON response for content '$contentKey'.");
                    }
                    $targetContent = $targetContent[$keyPart];
                }
            }

            if (is_string($targetContent)) {
                $flattenedResponse = $targetContent;
            } else {
                // Otherwise, flatten the nested array
                $flattenedResponse = implode(', ', Arr::flatten($targetContent));
            }

            $count = count($expectedStrings);
            $messagePrefix = $message ? $message . ': ' : '';

            for ($i = 0; $i < $count; $i++) {
                $expectedString = $expectedStrings[$i];

                if (!$position = mb_stripos($flattenedResponse, $expectedString)) {
                    PHPUnitAssert::fail($messagePrefix . "Missing expected string '{$expectedString}' in JSON response.");
                }

                $flattenedResponse = Str::substr($flattenedResponse, $position + mb_strlen($expectedString));

                if ($i < $count - 1) {
                    $nextExpected = $expectedStrings[$i + 1];

                    if (!mb_stripos($flattenedResponse, $nextExpected)) {
                        PHPUnitAssert::fail($messagePrefix . "Expected string '{$nextExpected}' to follow '{$expectedString}' but not found.");
                    }
                }
            }

            PHPUnitAssert::assertTrue(true); // Replace with more specific assertion if needed
        });
    }

    public function ajaxGet($uri){
        return $this->json(
            method: 'get',
            uri: $uri,
            headers: ['HTTP_X-Requested-With' => 'XMLHttpRequest']
        );
    }

    public function ajaxPost($uri, $parameters = []){
        return $this->json(
            method: 'post',
            uri: $uri,
            data: $parameters,
            headers: ['HTTP_X-Requested-With' => 'XMLHttpRequest']
        );
    }

}
