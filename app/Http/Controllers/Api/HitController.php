<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Http\Requests\StoreHitRequest;
use App\Models\Hit;
use Illuminate\Support\Facades\Log;
use Exception;

class HitController extends Controller
{
    public function __construct() { }
    
    public function store(StoreHitRequest $request)
    {
        try {
            $fields = $request->all();

            $hit = Hit::create($fields);

            return response()->json(['response' => true, 'message' => '', 'result' => $hit], 200);
        } catch (Exception $e) {
            Log::error('Error en /api/hits', ['error' => $e->getMessage()]);
            return response()->json(['response' => false, 'message' => 'Unexpected server error. Please try again later.', 'result' => null], 500);
        }
    }
}
