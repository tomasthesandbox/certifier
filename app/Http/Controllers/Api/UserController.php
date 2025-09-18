<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Http\Requests\StoreHitRequest;
use App\Mail\CodeVerification;
use App\Models\AccessLog;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Exception;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Mail;

class UserController extends Controller
{
    protected $hitController;

    public function __construct(HitController $hitController) {
        $this->hitController = $hitController;
    }

    public function generateToken(Request $request) {
        try {
            $fields = $request->validate([
                'email' => 'required|string'
            ]);
            return response()->json(['response' => true, 'message' => $fields, 'result' => null], 200);
            $user = User::where('email', $fields['email'])->firstOrFail();

            $code = rand(100000, 999999);
            $token = Hash::make($code);

            AccessLog::create([
                'user_id' => $user->id,
                'token' => $token,
                'failed_attempts' => 0,
                'date_of_use' => null
            ]);

            Mail::to($user->email)->send(new CodeVerification(['code' => $code]));

            $request = new StoreHitRequest([
                'user_id' => $user->id,
                'type' => 'generateToken'
            ]);
            $this->hitController->store($request);

            return response()->json(['response' => true, 'message' => 'Token successfully sent', 'result' => null], 200);
        } catch (Exception $e) {
            Log::error('Error en /api/generate-token', ['error' => $e->getMessage()]);
            return response()->json(['response' => false, 'message' => 'Unexpected server error. Please try again later.', 'result' => null], 500);
        }
    }

    public function validateToken(Request $request) {
        try {
            $fields = $request->validate([
                'email' => 'required|email',
                'code' => 'required|integer|min:100000|max:999999'
            ]);

            $user = User::where('email', $fields['email'])->firstOrFail();
            $accessLog = AccessLog::where('user_id', $user->id)->where('failed_attempts', '<', 3)->whereNull('date_of_use')->latest()->first();

            if (!Hash::check($fields['code'], $accessLog->token)) {
                $accessLog->failed_attempts = $accessLog->failed_attempts + 1;
                $accessLog->save();

                if ($accessLog->failed_attempts < 3) return response()->json(['response' => false, 'message' => 'The code entered in the platform is incorrect. Please request a new code to enter.', 'result' => null], 200);

                return response()->json(['response' => false, 'message' => 'You have reached the maximum number of attempts, resend the code again.', 'result' => 3], 200);
            }

            $jsonWebToken = $user->createToken('appcertifierToken')->plainTextToken;

            $accessLog->date_of_use = now();
            $accessLog->save();

            $request = new StoreHitRequest([
                'user_id' => $user->id,
                'type' => 'validateToken'
            ]);
            $this->hitController->store($request);

            return response()->json(['response' => true, 'message' => 'User successfully logged in.', 'result' => ['user' => $user, 'auth_token' => $jsonWebToken]], 201);
        } catch (Exception $e) {
            Log::error('Error en /api/validate-token', ['error' => $e->getMessage()]);
            return response()->json(['response' => false, 'message' => 'Unexpected server error. Please try again later.', 'result' => null], 500);
        }
    }

    public function logout(Request $request)
    {
        try {
            $user = User::where('id', Auth::user()->id)->first();
            $user->tokens()->delete();

            return response()->json(['response' => true, 'message' => 'Logged out', 'result' => null], 200);
        } catch (Exception $e) {
            Log::error('Error en /api/logout', ['error' => $e->getMessage()]);
            return response()->json(['response' => false, 'message' => 'Unexpected server error. Please try again later.', 'result' => null], 500);
        }
    }

    public function get(Request $request)
    {
        try {
            $user = User::where('id', Auth::user()->id)->with(['role' => function($query) {
                $query->select(['id', 'description']);
            }, 'organization' => function($query) {
                $query->select(['id', 'name']);
            }, 'association' => function($query) {
                $query->select(['id', 'name']);
            }])->first();

            return response()->json(['response' => true, 'message' => '', 'result' => $user], 200);
        } catch (Exception $e) {
            Log::error('Error en /api/users', ['error' => $e->getMessage()]);
            return response()->json(['response' => false, 'message' => 'Unexpected server error. Please try again later.', 'result' => null], 500);
        }
    }
}
