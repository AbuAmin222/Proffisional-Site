<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use Carbon\Carbon;
use Illuminate\Http\Request;

class EmailVerificationController extends Controller
{
    function verify(Request $request, $guard)
    {
        $token = $request->query('token');
        $guard = $request->route('guard');

        $provider = config("auth.guards.$guard.provider");
        $modelClass = config("auth.providers.$provider.model");

        $user = $modelClass::where('verification_token', $token)->first();
        $sendAt = Carbon::parse($user->verification_token_sent_at);
        if(Carbon::now()->diffInHours($sendAt) > 6){
            return 'The link has expired...';
        }

        $user->update([
            'verification_token' => null,
            'verification_token_sent_at' => null,
            'email_verified_at' => now(),
        ]);

        return redirect()->route($guard . '.emailVerifiedS');


    }
}
