<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\Category;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;
use Exception;

class CategoryController extends Controller
{
    public function __construct() { }

    public function getAll(Request $request)
    {
        try {
            $categories = Category::with(['subcategories' => function($query) {
                $query->orderBy('order', 'asc');
            }])->get();

            return response()->json(['response' => true, 'message' => '', 'result' => $categories], 200);
        } catch (Exception $e) {
            Log::error('Error en /api/categories', ['error' => $e->getMessage()]);
            return response()->json(['response' => false, 'message' => 'Unexpected server error. Please try again later.', 'result' => null], 500);
        }
    }
}
