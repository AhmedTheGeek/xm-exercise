<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Http\ResponseTrait;
use Illuminate\Http\JsonResponse;

class Historical extends Controller
{
    use ResponseTrait;

    /**
     * @param Request $request
     *
     * @return JsonResponse
     */
    public function process(Request $request): JsonResponse {
        return response()->json(['name' => 'ahmed']);
    }
}
