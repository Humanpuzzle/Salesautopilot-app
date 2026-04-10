<?php

namespace App\Http\Controllers\Api;

use App\Exceptions\SapiException;
use App\Http\Controllers\Controller;
use App\Services\SapiListService;

class SapiListController extends Controller
{
    public function lists(SapiListService $sapi)
    {
        try {
            $lists = $sapi->getLists();

            if (empty($lists)) {
                return view('lists.index', [
                    'lists' => [],
                    'message' => 'Nincsenek listák vagy feliratkozók.'
                ]);
            }

            $lists = collect($lists)->map(function ($list) {
                return [
                    'id' => $list['id'] ?? null,
                    'name' => $list['name'] ?? 'N/A',
                    'size' => $list['size'] ?? 0,
                    'created_at' => $list['created_at'] ?? '-',
                ];
            });

            return view('lists.index', [ 'lists' => $lists]);

        } catch (SapiException $e) {
            return view('lists.index', [
                'lists' => [],
                'error' => $e->getMessage()
            ]);
        }
    }


}

