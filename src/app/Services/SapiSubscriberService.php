<?php

namespace App\Services;

use App\Services\SapiClient;

class SapiSubscriberService
{
    protected SapiClient $client;

    public function __construct(SapiClient $client)
    {
        $this->client = $client;
    }



    // Filter endpoint
    public function searchSubscribers(string $listId, string $field, string $value): array
    {
        if (config('services.sapi.mock')) {
            $data = [
                [
                    'email' => 'test1@example.com',
                    'name' => 'Teszt Elek',
                    'active' => 1,
                    'subdate' => '2024-01-01'
                ],
                [
                    'email' => 'test2@example.com',
                    'name' => 'Kiss Béla',
                    'active' => 0,
                    'subdate' => '2024-02-01'
                ],
                [
                    'email' => 'john.doe@gmail.com',
                    'name' => 'John Doe',
                    'active' => 1,
                    'subdate' => '2024-02-10'
                ],
                [
                    'email' => 'anna@test.com',
                    'name' => 'Kiss Anna',
                    'active' => 0,
                    'subdate' => '2024-03-05'
                ],
            ];

            // "*gmail*" -> gmail
            $needle = str_replace('*', '', strtolower($value));

            return collect($data)
                ->filter(function ($item) use ($field, $needle) {
                    return str_contains(strtolower($item[$field] ?? ''), $needle);
                })
                ->values()
                ->all();
        }

        return $this->client->post("/list/{$listId}/field/{$field}/value/{$value}");
    }

    // Sort + Limit endpoint
    public function getSubscribersSorted(string $listId, string $field, string $order, int $limit): array
    {
        if (config('services.sapi.mock')) {
            return [
                [
                    'email' => 'test1@example.com',
                    'name' => 'Teszt Elek',
                    'active' => 1,
                    'subdate' => '2024-01-01'
                ],
                [
                    'email' => 'test2@example.com',
                    'name' => 'Kiss Béla',
                    'active' => 0,
                    'subdate' => '2024-02-01'
                ],
                [
                    'email' => 'john.doe@gmail.com',
                    'name' => 'John Doe',
                    'active' => 1,
                    'subdate' => '2024-02-10'
                ],
                [
                    'email' => 'anna@test.com',
                    'name' => 'Kiss Anna',
                    'active' => 0,
                    'subdate' => '2024-03-05'
                ],
            ];
        }

        return $this->client->post("/list/{$listId}/order/{$field}/{$order}/{$limit}");
    }


}
