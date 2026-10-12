<?php

namespace Mips\Http;

use ArrayObject;

class HttpHeader {

    protected ArrayObject $headers;

    public function __construct() {
        $this->headers = new ArrayObject();
    }

    public function headerExists(string $header): bool {
        return $this->headers->offsetExists($header);
    }

    public function setHeader(string $header, string $value): void {
        $this->headers->offsetSet($header, $value);
    }

    public function getHeader(string $header): ?string {
        return $this->headers->offsetGet($header);
    }

    public function removeHeader(string $header): void {
        $this->headers->offsetUnset($header);
    }

    public function mergeHeaders(HttpHeader $_headers): void {
        foreach ($_headers->getIterator() as $key => $value) {
            $this->setHeader($key, $value);
        }
    }

    public function getHeadersForHttp(): array {
        $return = array();
        foreach ($this->headers as $key => $value) {
            $return[] = "{$key}: {$value}";
        }

        return $return;
    }

    public function count(): int {
        return $this->headers->count();
    }

    public function getIterator(): \ArrayIterator {
        return $this->headers->getIterator();
    }
}
