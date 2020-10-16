<?php

namespace App\Http\Controllers;

use Illuminate\Http\ResponseTrait;
use Illuminate\Http\JsonResponse;
use App\Http\Requests\HistoricalQuery;

class Historical extends Controller {

    use ResponseTrait;

    /**
     * @param HistoricalQuery $request
     *
     * @return JsonResponse
     */
    public function get( HistoricalQuery $request ): JsonResponse {
        if ( $request->validated() ) {
            return response()->json( [ 'name' => 'ahmed' ] );
        }
    }
}
