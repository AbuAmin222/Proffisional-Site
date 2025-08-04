<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Models\Admin;
use App\Models\Freelancer;
use App\Models\User;
use App\Notifications\forgetPasswordNotification;
use App\Notifications\verifyEmailNotification;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Str;

class AuthController extends Controller
{
    function index(Request $request)
    {
        $guard = $request->route('guard');
        return view('auth.login', compact('guard'));
    }

    function login(Request $request)
    {
        $guard = $request->route('guard');
        $data = $request->validate([
            'email' => ['required', 'email'],
            'password' => ['required', 'string', 'min:8'],
        ], [
            'email.required' => 'Email is required',
            'email.email' => 'Invalid email',
            'password.required' => 'Password is required',
            'password.string' => 'Password must be a string',
            'password.min' => 'Password must be at least 8 characters',
        ]);

        if (Auth::guard($guard)->attempt($data, $request->filled('remember'))) {
            return redirect()->route("{$guard}.dashboard");
        }
        return redirect()->back();
    }

    function indexregister(Request $request)
    {
        $guard = $request->route('guard');
        return view('Auth.register', compact('guard'));
    }

    function register(Request $request)
    {
        $guard = $request->route('guard');

        $provider = config("auth.guards.$guard.provider");
        $modelClass = config("auth.providers.$provider.model");

        $token = Str::random();
        $user = $modelClass::create([
            'name' => $request->fullName,
            'email' => $request->email,
            'password' => Hash::make($request->password),
            'verification_token' => $token,
            'verification_token_sent_at' => now(),
        ]);

        $user->notify(new verifyEmailNotification($guard, $token));

        return redirect()->route($guard . '.emailVerified', ['id' => $user->id]);
    }
    function dashboard(Request $request)
    {
        $viewName = $request->route('guard') . '.dashboard';
        return view($viewName);
    }
    function indexForgetPass(Request $request)
    {
        $guard = $request->route('guard');
        return view('Auth.forget-password', compact('guard'));
    }
    function forgetPass(Request $request)
    {
        $guard = $request->route('guard');

        $provider = config("auth.guards.$guard.provider");
        $modelClass = config("auth.providers.$provider.model");

        $user = $modelClass::where('email', $request->email)->first();
        if (! $user) {
            return redirect()->back()->withErrors(['email' => 'This mail isn`t register!!! Please register first...'])->withInput();
        }

        $token = Str::random();
        $user->update([
            'verification_token' => $token,
            'verification_token_sent_at' => now(),
        ]);

        $user->notify(new forgetPasswordNotification($guard, $token));

        return redirect()->route($guard . '.confirm', ['id' => $user->id]);
    }
    function confirm(Request $request, $id)
    {
        $guard = $request->route('guard');
        $provider = config("auth.guards.$guard.provider");
        $modelClass = config("auth.providers.$provider.model");

        $data = $modelClass::findOrFail($id);
        if (! $data) {
            abort(404, 'User not found');
        }
        $email = $data->email;
        return view('Auth.verifiedPassword', compact('guard', 'email'));
    }
    function resetPass(Request $request)
    {
        $guard = $request->route('guard');
        $provider = config("auth.guards.$guard.provider");
        $modelClass = config("auth.providers.$provider.model");

        $user = $modelClass::findOrFail($request->id);

        if (!$user) {
            return redirect()->back()->withErrors(['email' => 'This mail isn`t register!!! Please register
            first...'])->withInput();
        }
        $user->update([
            'password' => Hash::make($request->password),
        ]);

        return redirect()->route($guard . '.dashboard');
    }
    function emailVerified(Request $request, $id){
        $guard = $request->route('guard');
        $provider = config("auth.guards.$guard.provider");
        $modelClass = config("auth.providers.$provider.model");
        $user = $modelClass::FindOrFail($request->id);
        $email = $user->email;
        return view('Auth.verifiedMail', compact('guard', 'email'));
    }
    function emailVerifiedS(Request $request){
        $guard = $request->route('guard');
        return view('Auth.confirmEmail', compact('guard'));
    }
}
