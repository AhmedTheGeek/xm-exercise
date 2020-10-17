<?php

namespace App\Http\Controllers;

use App\Repositories\Symbol\SymbolRepository;
use Illuminate\Http\JsonResponse;

class Symbol extends Controller {

    /**
     * @var SymbolRepository
     */
    private $repository;


    /**
     * Symbol constructor.
     *
     * @param SymbolRepository $repository
     */
    public function __construct( SymbolRepository $repository ) {
        $this->repository = $repository;
    }


    /**
     * Gets a list of symbol definitions
     *
     * @return JsonResponse
     */
    public function get(): JsonResponse {
        return jsend_success( $this->repository->getAll() );
    }
}
