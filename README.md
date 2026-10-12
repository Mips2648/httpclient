# httpclient

[![CI](https://github.com/mips2648/httpclient/actions/workflows/ci.yml/badge.svg)](https://github.com/mips2648/httpclient/actions/workflows/ci.yml)

Small PHP HTTP client for JSON APIs.

## Requirements

- PHP 8.2 or later
- The PHP cURL extension
- Composer

## Installation

Install the package with Composer:

```sh
composer require mips/httpclient
```

Load Composer's autoloader in your application:

```php
require __DIR__ . '/vendor/autoload.php';
```

## Usage

Create a client with the API base URL. The client adds JSON `Content-Type` and
`Accept` headers by default. For a GET request, the data array is encoded as
query parameters:

```php
use Mips\Http\HttpClient;

$client = new HttpClient('https://api.example.com');
$response = $client->doGet('users', ['page' => 1]);

if (!$response->isSuccess()) {
	throw new RuntimeException(sprintf(
		'Request failed with HTTP status %d: %s',
		$response->getHttpStatusCode(),
		$response->getError()
	));
}

$users = json_decode($response->getBody(), true, 512, JSON_THROW_ON_ERROR);
```

POST, PUT, and DELETE requests send the data array as a JSON body. The client
also provides `doPost()`, `doPut()`, and `doDelete()` methods, or you can use
`doRequest()` with one of the supported methods (`GET`, `POST`, `PUT`, or
`DELETE`):

```php
$response = $client->doPost('users', [
	'name' => 'Ada Lovelace',
	'email' => 'ada@example.com',
]);
```

### Authentication and headers

Set Basic Authentication credentials with `setBasicAuth()`. Add headers to all
requests through `getHttpHeaders()`, or pass an `HttpHeader` object to a single
request:

```php
use Mips\Http\HttpHeader;

$client->setBasicAuth('api-user', 'secret');
$client->getHttpHeaders()->setHeader('X-API-Key', 'your-api-key');

$requestHeaders = new HttpHeader();
$requestHeaders->setHeader('X-Request-Id', 'request-123');
$response = $client->doGet('users', [], $requestHeaders);
```

`HttpHeader` also provides `headerExists()`, `getHeader()`, `removeHeader()`,
`mergeHeaders()`, `getHeadersForHttp()`, `count()`, and `getIterator()`.

### Responses

Each request returns an `HttpResponse`:

- `getHttpStatusCode()` returns the HTTP status code.
- `getBody()` returns the response body as a string; decode JSON as needed.
- `isSuccess()` is true for status codes from 200 to 299.
- `getError()` returns the cURL transport error, or an empty string when there
  is no transport error. An HTTP error status does not necessarily populate it.

An optional PSR-3 `LoggerInterface` can be passed to the constructor or set
later with `setLogger()`. Without one, the client uses `NullLogger`.

## Tests

Install the development dependencies and run the PHPUnit suite:

```sh
composer install
composer test
```
