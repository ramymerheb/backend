<?php

namespace App\Http\Controllers\Client;

use App\Http\Controllers\Controller;
use App\Http\Requests\Client\ClientRequest;
use App\Models\Client;

class ClientController extends Controller
{
    public function register(ClientRequest $request) {
        $client = Client::create(array_merge(
            $request->validated()
        ));

        return response()->json([
            'message' => 'Client successfully registered',
            'client' => $client
        ], 201);
    }

}
