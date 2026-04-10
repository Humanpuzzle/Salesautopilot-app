<?php

namespace App\Services;

use App\Services\SapiClient;

class SapiListService
{
    protected SapiClient $client;

    public function __construct(SapiClient $client)
    {
        $this->client = $client;
    }

    public function getLists()
    {
        if (config('services.sapi.mock')) {
            return [
                ['id' => '8637', 'name' => 'CRM-lista'],
                ['id' => '21849', 'name' => 'PiacépítőRendszerReg'],
            ];
        }

        return $this->client->get('/getlists');
    }

}
