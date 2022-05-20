<?php

namespace App\Http\Controllers;

use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;

class VerificationController extends Controller
{
    /**
     * @param Request $request
     * @return \Illuminate\Http\JsonResponse
     */
    public function sendMail(Request $request): JsonResponse
    {
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
     * @return \Illuminate\Http\JsonResponse
     */
    public function verify(Request $request)
    {
        $request->user()->markEmailAsVerified();
        return response()->json([
            'message' => 'mail verified at ' . $request->user()->email_verified_at
        ]);
    }
}
