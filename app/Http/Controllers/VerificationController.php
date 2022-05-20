<?php

namespace App\Http\Controllers;

use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Config;

class VerificationController extends Controller
{
    /**
     * @param Request $request
     * @return JsonResponse
     */
    public function sendMail(Request $request): JsonResponse
    {
        Config::get('auth.verification.expire', 0);
        if (!$request->user()->hasVerifiedEmail()) {
            $request->user()->sendEmailVerificationNotification();
            return response()->json([
                'message' => 'check your email'
            ]);
        } else {
            return response()->json([
                'message' => 'your mail is verified at ' . $request->user()->email_verified_at
            ]);
        }
    }

    /**
     * @param Request $request
     * @return JsonResponse
     */
    public function verify(Request $request): JsonResponse
    {
        if ($request->user()->hasVerifiedEmail()) {
            return response()->json([
                'message' => 'your mail is verified at ' . $request->user()->email_verified_at
            ]);
        }
        $request->user()->markEmailAsVerified();
        return response()->json([
            'message' => 'mail verified at ' . $request->user()->email_verified_at
        ]);
    }
}
