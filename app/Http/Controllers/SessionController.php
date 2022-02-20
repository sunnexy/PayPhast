<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use App\Models\User;
use Auth;

class SessionController extends Controller
{
    public function createLogin()
    {
        return view('login');
    }

    public function login(Request $request)
    {
        $this->validate($request, [
            'email' => 'required|string|',
            'password' => 'required|string',
        ]);
        $user = $request->only('email', 'password');
        if(Auth::attempt($user)){
            return redirect()->route('index');
        }
        return redirect("/")->with('errors', 'Please check details and login again');
       
    }

    public function logout()
    {
        if(Auth::check()){
            auth()->logout();
            return redirect('/');
        }
        return view('login');
    }
}
