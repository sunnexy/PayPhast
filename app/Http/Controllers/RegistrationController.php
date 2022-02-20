<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use App\Models\User;


class RegistrationController extends Controller
{
    public function createUser()
    {
        return view('register');
    }

    public function register(Request $request)
    {
        $this->validate($request, [
            'name' => 'required',
            'email' => 'required|email|unique:users',
            'password' => 'required'
         ]);
       
         $user = new User($request->all());
         $user->password = Hash::make($request->password);
         $user->save();
         if($user){
            return redirect()->route('login');
         }
         return redirect()->back()->with('errors', 'Incomplete details');
    }
}
