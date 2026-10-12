<?php

namespace Mips\Http\Tests\Unit;

use Mips\Http\HttpResponse;
use PHPUnit\Framework\TestCase;

class HttpResponseTest extends TestCase {

    public function testExposesStatusBodyAndError(): void {
        $response = new HttpResponse(503, '{"message":"unavailable"}', 'connection failed');

        self::assertSame(503, $response->getHttpStatusCode());
        self::assertSame('{"message":"unavailable"}', $response->getBody());
        self::assertSame('connection failed', $response->getError());
    }

    public function testSuccessIsTrueOnlyForTwoHundredStatuses(): void {
        foreach ([200, 201, 299] as $statusCode) {
            self::assertTrue((new HttpResponse($statusCode, ''))->isSuccess());
        }

        foreach ([199, 300, 404, 500] as $statusCode) {
            self::assertFalse((new HttpResponse($statusCode, ''))->isSuccess());
        }
    }

    public function testErrorDefaultsToEmptyString(): void {
        self::assertSame('', (new HttpResponse(204, ''))->getError());
    }
}
