<?php

namespace App\Http\Controllers;

use Illuminate\Foundation\Auth\User;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Http\Response;

class VerificationController extends Controller
{
    /**
     * @param Request $request
     * @return JsonResponse
     */
    public function sendMail(Request $request): JsonResponse
    {
        if ($request->user()->hasVerifiedEmail()) {
            return new JsonResponse(['message' => 'your mail is verified at ' . $request->user()->email_verified_at, Response::HTTP_OK]);
        }

        $request->user()->sendEmailVerificationNotification();

        return new JsonResponse(['message' => 'check your email', Response::HTTP_OK]);
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
