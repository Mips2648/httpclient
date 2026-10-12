<?php

namespace Mips\Http;

class HttpResponse {

    private int $httpStatusCode;
    private string $body;
    private string $error;

    public function __construct(int $httpCode, string $body, string $error = '') {
        $this->httpStatusCode = (int)$httpCode;
        $this->body = $body;
        $this->error = $error;
    }

    public function getBody(): string {
        return $this->body;
    }

    public function getHttpStatusCode(): int {
        return $this->httpStatusCode;
    }

    public function getError(): string {
        return $this->error;
    }

    public function isSuccess(): bool {
        return $this->httpStatusCode >= 200 && $this->httpStatusCode < 300;
    }
}
