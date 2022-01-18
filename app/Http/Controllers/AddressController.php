<?php

namespace App\Http\Controllers;

use App\Http\Requests\SubmitContactRequest;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Cache;
use Illuminate\Support\Facades\Http;

class AddressController extends Controller
{
    private $states_endpoints = [
        'USA' => [
            'url' => 'https://gist.githubusercontent.com/pbojinov/a87adf559d2f7e81d86ae67e7bd883c7/raw/f34362c96cce2e40b1cab4e330f4affb6c12d37e/us_states_titlecase.json',
            'key' => 'address.usa_state_list'
        ],
        'CAN' => [
            'url' => 'https://gist.githubusercontent.com/pbojinov/a87adf559d2f7e81d86ae67e7bd883c7/raw/f34362c96cce2e40b1cab4e330f4affb6c12d37e/canada_states_titlecase.json',
            'key' => 'address.can_state_list'
        ]
    ];

    public function getStateListForCountry(string $country)
    {
        $data = [];

        if (array_key_exists($country, $this->states_endpoints)) {
            $data = Cache::rememberForever($this->states_endpoints[$country]['key'], function() use ($country) {
                $response = Http::get($this->states_endpoints[$country]['url']);
                return $response->json();
            });
        }

        return response()->json(['states' => $data]);
    }

    public function save(SubmitContactRequest $request)
    {
        $validated = $request->validated();
        dd($validated);
    }
}
