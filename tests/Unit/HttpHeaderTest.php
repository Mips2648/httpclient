<?php

namespace Mips\Http\Tests\Unit;

use Mips\Http\HttpHeader;
use PHPUnit\Framework\TestCase;

class HttpHeaderTest extends TestCase {

    public function testHeaderCanBeSetRetrievedAndRemoved(): void {
        $headers = new HttpHeader();

        $headers->setHeader('Accept', 'application/json');

        self::assertTrue($headers->headerExists('Accept'));
        self::assertSame('application/json', $headers->getHeader('Accept'));
        self::assertSame(1, $headers->count());

        $headers->removeHeader('Accept');

        self::assertFalse($headers->headerExists('Accept'));
        self::assertSame(0, $headers->count());
    }

    public function testMergeHeadersAddsAndReplacesValues(): void {
        $headers = new HttpHeader();
        $headers->setHeader('Accept', 'text/plain');
        $newHeaders = new HttpHeader();
        $newHeaders->setHeader('Accept', 'application/json');
        $newHeaders->setHeader('X-Request-Id', '123');

        $headers->mergeHeaders($newHeaders);

        self::assertSame('application/json', $headers->getHeader('Accept'));
        self::assertSame('123', $headers->getHeader('X-Request-Id'));
        self::assertSame(2, $headers->count());
    }

    public function testHeadersCanBeFormattedForHttp(): void {
        $headers = new HttpHeader();
        $headers->setHeader('Accept', 'application/json');
        $headers->setHeader('X-Request-Id', '123');

        self::assertSame(
            ['Accept: application/json', 'X-Request-Id: 123'],
            $headers->getHeadersForHttp()
        );
    }
}
