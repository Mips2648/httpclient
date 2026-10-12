<?php

namespace Mips\Http;

class HttpHeader {

    /** @var array<string, string> */
    protected array $headers = [];

    public function headerExists(string $header): bool {
        return array_key_exists($header, $this->headers);
    }

    public function setHeader(string $header, string $value): void {
        $this->headers[$header] = $value;
    }

    public function getHeader(string $header): ?string {
        return $this->headers[$header] ?? null;
    }

    public function removeHeader(string $header): void {
        unset($this->headers[$header]);
    }

    public function mergeHeaders(HttpHeader $_headers): void {
        foreach ($_headers->headers as $key => $value) {
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
        return count($this->headers);
    }
}
