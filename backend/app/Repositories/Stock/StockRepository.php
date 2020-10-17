<?php

namespace App\Repositories\Stock;

interface StockRepository {
    public function getInRange( $symbol, $start_date, $end_date );
}
