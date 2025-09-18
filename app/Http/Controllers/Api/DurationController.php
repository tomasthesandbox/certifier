<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\Duration;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;
use Exception;

class DurationController extends Controller
{
    public function __construct() { }

    public function getAll(Request $request)
    {
        try {
            $durations = Duration::get();

            return response()->json(['response' => true, 'message' => '', 'result' => $durations], 200);
        } catch (Exception $e) {
            Log::error('Error en /api/subcategories', ['error' => $e->getMessage()]);
            return response()->json(['response' => false, 'message' => 'Unexpected server error. Please try again later.', 'result' => null], 500);
        }
    }
}
