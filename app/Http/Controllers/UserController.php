<?php

namespace App\Http\Controllers;

<<<<<<< HEAD
=======
use App\Mail\Sender;
use Illuminate\Auth\Events\Registered;
use Illuminate\Foundation\Auth\EmailVerificationRequest;
use Illuminate\Http\JsonResponse;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Mail;
>>>>>>> b822abfa06a9fa94c71eb84139d30dbb005a7c84
use Illuminate\Support\Facades\Validator;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;

class UserController extends Controller
{

    /**
     * @param Request $request
     * @return JsonResponse|void
     */
    public function register(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'name' => 'required|string|min:2|max:100',
            'email' => 'required|string|email|max:100|unique:users',
            'password' => 'required|string|confirmed|min:6',
        ]);

        if ($validator->fails()) {
            return response()->json($validator->errors(), 400);
        }

        $details = [
            'email=' . $request->email ,
            'password=' . Hash::make($request->password),
            'name=' . $request->name
        ];

        $this->sendMail($details, $request->email);
    }

    /**
     * @param Request $request
     * @return \Illuminate\Http\JsonResponse
     * @throws \Illuminate\Validation\ValidationException
     */
    public function login(Request $request)
    {
        $this->validate($request, [
            'email' => 'required|email',
            'password' => 'required|string|min:6',
        ]);

        if (!$token = auth()->attempt($request->all())) {
            return response()->json(['error' => 'Unauthorized'], 401);
        }

        return $this->respondWithToken($token);
    }

    /**
     * @return \Illuminate\Http\JsonResponse
     */
    public function logout()
    {
        auth()->logout();

        return response()->json(['message' => 'User successfully logged out.']);
    }


    public function profile()
    {
        return response()->json(auth()->user());
    }

    /**
     * @param $token
     * @return \Illuminate\Http\JsonResponse
     */
    protected function respondWithToken($token)
    {
        return response()->json([
            'access_token' => $token,
            'token_type' => 'Bearer',
            'expires_in' => auth()->factory()->getTTL() * 60
        ]);
    }


    public function sendMail($token , $email)
    {
        $details = [
            'title' => 'verify mail',
            'body' => 'http://127.0.0.1:8000/api/verify?' . implode('&',$token)
        ];

        Mail::to($email)->send(new Sender($details));
        return "aaa";
    }

    public function verification(Request $request)
    {
        $user = new User();
        $details = $request->toArray();
        $user->name = $details['name'];
        $user->email = $details['email'];
        $user->password = $details['password'];
        $user->save();
        return response()->json([
            'message' => 'User successfully registered',
            'user' => $user
        ], 201);
    }
}
