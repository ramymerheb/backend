<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Http\Filters\ClientsFilter;
use App\Http\Resources\ClientCollection;
use Illuminate\Http\Request;
use App\Models\Client;

class ClientController extends Controller
{
    public function __construct() {
        $this->middleware('jwt.auth');
    }

    /**
     * @param Request $request
     * @return ClientCollection
     */
    public function index(Request $request): ClientCollection
    {
        $filter = new ClientsFilter($request);
        $query = Client::select('*')
            ->orderBy('created_at', 'DESC')
            ->filter($filter);
        $rowsPerPage = $request->input('rowsPerPage', 20);
        $collection = new ClientCollection($query->paginate($rowsPerPage));

        return $collection->preserveQuery();
    }

    /**
     * @param Request $request
     * @param $days
     * @return mixed
     */
    public function count(Request $request, $days)
    {
      $client = new Client();
      return $client->count($days);
    }
}
