<?php

namespace App\Http\Controllers;

use App\Repositories\Symbol\SymbolRepository;
use Illuminate\Http\ResponseTrait;
use Illuminate\Http\JsonResponse;
use App\Http\Requests\HistoricalQuery;

class Historical extends Controller {

    use ResponseTrait;

    private $symbolRepository;


    public function __construct( SymbolRepository $symbolRepository ) {
        $this->symbolRepository = $symbolRepository;
    }


    /**
     * @param HistoricalQuery $request
     *
     * @return JsonResponse
     */
    public function get( HistoricalQuery $request ): string {
        if ( $request->validated() ) {

            return $this->symbolRepository->getInRange($request->symbol, $request->startDate, $request->endDate );
        }

        return ["message" => "error"];
    }
}
