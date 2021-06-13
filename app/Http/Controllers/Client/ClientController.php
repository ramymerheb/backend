<?php

namespace App\Http\Controllers\Client;

use App\Http\Controllers\Controller;
use App\Http\Requests\Client\ClientRequest;
use App\Models\Client;
use Illuminate\Support\Facades\Config;

class ClientController extends Controller
{
    public function register(ClientRequest $request) {
        $image = $request->file('image');
        $s3 = \Storage::disk('s3');
        $file_name = uniqid() .'.'. $image->getClientOriginalExtension();
        $s3filePath = '/assets/' . $file_name;
        $s3 = $s3->put($s3filePath, file_get_contents($image), 'public');

        if($s3){
            $client = Client::create(array_merge(
                $request->validated(),
                ["image"=>config('custom.aws_base_url').$s3filePath]
            ));
        }

        return response()->json([
            'message' => 'Client successfully registered',
            'client' => config('custom.aws_base_url'),
        ], 201);
    }

}
