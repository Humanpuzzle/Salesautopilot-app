<?php

namespace App\Http\Controllers\Api;

use App\Exceptions\SapiException;
use App\Http\Controllers\Controller;
use App\Services\SapiSubscriberService;
use Illuminate\Http\Request;

class SapiSubscriberController extends Controller
{
    public function show($id, SapiSubscriberService $sapi, Request $request)
    {

        $request->validate([
            'search' => 'nullable|string|max:255',
            'sort' => 'nullable|in:email,subdate',
            'order' => 'nullable|in:asc,desc',
        ]);

        $search = $request->input('search');
        $sort = $request->input('sort', 'subdate');
        $order = $request->input('order', 'desc');
        $limit = 20;

        try {

            $subscribers = $search
                ? $sapi->searchSubscribers($id, 'email', "*{$search}*")
                : $sapi->getSubscribersSorted($id, $sort, $order, $limit);

            if (config('services.sapi.mock')) {
                $subscribers = collect($subscribers)
                    ->sortBy($sort)
                    ->values()
                    ->take($limit)
                    ->all();
            }

            if (empty($subscribers)) {
                return view('lists.show', [
                    'subscribers' => [],
                    'message' => 'Nincs ilyen lista vagy feliratkozó.'
                ]);
            }

            $subscribers = collect($subscribers)->map(function ($subscriber) {
                return [
                    'email' => $subscriber['email'] ?? 'N/A',
                    'name' => $subscriber['name'] ?? 'N/A',
                    'status' => !empty($subscriber['active']) ? 'Aktív' : 'Inaktív',
                    'subdate' => $subscriber['subdate'] ?? '-',
                ];
            });

        return view('lists.show', [
            'subscribers' => $subscribers,
            'search' => $search,
            'sort' => $sort,
            'order' => $order,
        ]);

        } catch (SapiException $e) {

            return view('lists.show', [
                'subscribers' => [],
                'error' => $e->getMessage()
            ]);
        }
    }
}
