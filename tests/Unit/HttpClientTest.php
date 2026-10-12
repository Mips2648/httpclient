<?php

namespace Mips\Http\Tests\Unit;

use InvalidArgumentException;
use Mips\Http\HttpClient;
use PHPUnit\Framework\TestCase;
use Psr\Log\NullLogger;

class HttpClientTest extends TestCase {

    public function testConstructorSetsDefaultHeadersAndLogger(): void {
        $client = new HttpClient('https://example.test/');

        self::assertSame('application/json; charset=utf-8', $client->getHttpHeaders()->getHeader('Content-Type'));
        self::assertSame('application/json', $client->getHttpHeaders()->getHeader('Accept'));
        self::assertInstanceOf(NullLogger::class, $client->getLogger());
    }

    public function testLoggerCanBeReplaced(): void {
        $client = new HttpClient('https://example.test');
        $logger = new NullLogger();

        $client->setLogger($logger);

        self::assertSame($logger, $client->getLogger());
    }

    public function testRequestRejectsUnsupportedMethodBeforeNetworkCall(): void {
        $client = new HttpClient('https://example.test');

        $this->expectException(InvalidArgumentException::class);
        $this->expectExceptionMessage('Method not supported:PATCH');

        $client->doRequest('patch', '/resource');
    }
}
