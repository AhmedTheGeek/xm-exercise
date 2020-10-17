<?php

namespace App\Http\Controllers;

use App\Repositories\Stock\StockRepository;
use App\Http\Requests\HistoricalQuery;
use Illuminate\Http\JsonResponse;
use Illuminate\Support\Facades\Mail;

class Historical extends Controller {

    /**
     * @var StockRepository
     */
    private $repository;


    /**
     * Historical constructor.
     *
     * @param StockRepository $symbolRepository
     */
    public function __construct( StockRepository $symbolRepository ) {
        $this->repository = $symbolRepository;
    }


    /**
     * Gets historical symbol data
     *
     * @param HistoricalQuery $request
     *
     * @return JsonResponse
     */
    public function get( HistoricalQuery $request ): JsonResponse {
        if ( $request->validated() ) {
            $this->sendEmail();

            return jsend_success( $this->repository->getInRange( request( 'symbol' ), request( 'startDate' ), request( 'endDate' ) ) );
        }

        return jsend_fail( [] );
    }


    /**
     * Sends an email to the email included in the request.
     * With the company name as the subject.
     * And formatted Start - End date as the content.
     */
    private function sendEmail() {
        $dateFormat = 'Y-m-d';
        $formattedStartDate = date( $dateFormat, request( 'startDate' ) );
        $formattedEndDate = date( $dateFormat, request( 'endDate' ) );
        Mail::raw( sprintf( '%s to %s', $formattedStartDate, $formattedEndDate ), function ( $message ) {
            $message->to( request( 'email' ) )->subject( request( 'companyName' ) );
        } );
    }
}
