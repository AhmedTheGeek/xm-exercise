<?php

namespace App\Repositories\Symbol;

interface SymbolRepository {
    public function getInRange( $symbol, $start_date, $end_date );
}
