<?php

namespace App\Http\Controllers;

use App\Models\SiteEmail;
use App\Models\User;
use Illuminate\Auth\Notifications\VerifyEmail;
use Illuminate\Http\Request;
use Illuminate\Auth\MustVerifyEmail;
use Illuminate\Auth\Events\Registered;

class VerificationController extends Controller
{
    use MustVerifyEmail;

    public function noti(Request $request)
    {
        $sitemail = new SiteEmail();
        if($sitemail->hasVerifiedEmail()){
            $sitemail->sendEmailVerificationNotification();
        };
    }

    public function notify(VerifyEmail $email)
    {
        dd($email->toMail());
    }
}
