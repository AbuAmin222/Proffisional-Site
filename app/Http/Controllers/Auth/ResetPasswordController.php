<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

class ResetPasswordController extends Controller
{
    public function indexReset(Request $request)
    {
        $guard = $request->route('guard');
        $token = $request->query('token');
        $id = $request->query('id');

        return view('Auth.reset-password', compact('guard', 'token', 'id'));
    }
    public function reset(Request $request)
    {
        dd($request->all());
    }
}
