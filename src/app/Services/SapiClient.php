<?php
namespace App\Services;

use GuzzleHttp\Client;
use App\Exceptions\SapiException;
use App\Services\SapiCredentials;
use GuzzleHttp\Exception\RequestException;
use GuzzleHttp\Exception\ConnectException;

class SapiClient
{
    protected Client $client;

    public function __construct()
    {
        if (!SapiCredentials::isConfigured()) {
            throw new SapiException(
                'SAPI credentials hiányoznak',
                'missing_credentials'
            );
        }

        $this->client = new Client([
            'base_uri' => config('services.sapi.base_url'),
            'timeout' => 10,
            'auth' => [
                SapiCredentials::username(),
                SapiCredentials::password(),
            ]
        ]);
    }

    public function get(string $uri): array
    {
        try {
            $response = $this->client->get($uri);

            return json_decode($response->getBody(), true);

        } catch (RequestException $e) {
            throw $this->handleRequestException($e);
        } catch (ConnectException $e) {
            throw new SapiException('API nem elérhető (timeout)', 'timeout');
        }
    }

    public function post(string $uri): array
    {
        try {
            $response = $this->client->post($uri);

            return json_decode($response->getBody(), true);

        } catch (RequestException $e) {
            throw $this->handleRequestException($e);
        } catch (ConnectException $e) {
            throw new SapiException('API nem elérhető (timeout)', 'timeout');
        }
    }

    protected function handleRequestException(RequestException $e): SapiException
    {
        $status = $e->getResponse()?->getStatusCode();

        return match ($status) {
            401 => new SapiException('Hibás API kulcs', 'invalid_credentials'),
            404 => new SapiException('Nem található erőforrás', 'not_found'),
            405 => new SapiException('Nem engedélyezett metódus', 'method_not_allowed'),
            406 => new SapiException('Hibás paraméterek', 'invalid_parameters'),
            429 => new SapiException('Túl sok kérés, rate limit elérve', 'rate_limit'),
            500 => new SapiException('Szerver hiba', 'server_error'),
            default => new SapiException('Ismeretlen API hiba', 'unknown'),
        };
    }
}
