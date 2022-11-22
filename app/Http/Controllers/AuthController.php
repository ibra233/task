<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Http\Requests\AuthRequest;
class AuthController extends Controller
{
    //
    public function login(AuthRequest $request){
       
        $validated = $request->validated();
      
        if (Auth::attempt(['email' => $validated['email'], 'password' => $validated['password']], $request->remember)) {
            return redirect('/');
        }else{ 
            return back()->with('error','Email ya da şifre yanlış.');
        }
    }
    public function logout()
    {
        Auth::logout();
        return redirect('/login');
    }
}
