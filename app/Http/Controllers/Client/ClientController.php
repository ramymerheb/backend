<?php

namespace App\Http\Controllers\Client;

use App\Http\Controllers\Controller;
use App\Http\Requests\Client\ClientRequest;
use App\Models\Client;
use Illuminate\Http\JsonResponse;
use Illuminate\Support\Facades\Config;

class ClientController extends Controller
{
    /**
     * @param ClientRequest $request
     * @return JsonResponse
     */
    public function register(ClientRequest $request): JsonResponse
    {
        $s3Put= false;
        $image = $request->file('image', false);
        if($image) {
            $s3 = \Storage::disk('s3');
            $file_name = uniqid() . '.' . $image->getClientOriginalExtension();
            $s3filePath = '/assets/' . $file_name;
            $s3Put = $s3->put($s3filePath, file_get_contents($image), 'public');
        }

        $data = ($s3Put && isset($image))? array_merge(
            $request->validated(),
            ["image"=>config('custom.aws_base_url').$s3filePath]
        ) : $request->validated();

        $client = Client::create($data);

        if($client){
            $client->sendEmailVerificationNotification();
        } else {
            return response()->json([
                'message' => 'Registration was unsuccessful',
            ], 401);
        }

        return response()->json([
            'message' => 'Client successfully registered',
            'client' => $client
        ], 201);
    }

}
