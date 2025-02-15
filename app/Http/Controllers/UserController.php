<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\User;
use Illuminate\Validation\Rule;

class UserController extends Controller
{
    public function register(Request $request){
        $data = $request->validate([
            'name' => ['required', 'string', 'max:50'],
            'email' => ['required', 'email', Rule::unique('users', 'email')],
            'password' => ['required', 'min:6']
        ]);

        $data['password'] = bcrypt($data['password']);
        $user = User::create($data);
        auth()->login($user);
        return redirect('/');
    }

    public function logout(){
        auth()->logout();
        return redirect('/');
    }

    public function login(Request $request){
        $data = $request->validate([
            'login-email' => ['required', 'email'],
            'login-password' => ['required']
        ]);

        if(auth()->attempt(['email' => $data['login-email'], 'password' => $data['login-password']])){
            $request->session()->regenerate();
            return redirect('/');
        }

        return redirect('/login-page')->withErrors([
            'login-email' => 'The provided credentials do not match our records.',
        ]);
    }
}
