<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\User;
class AuthController extends Controller
{
    public function login(){
        return view('auth.login');
    }

    public function store(Request $request){
        $request->validate([
            'email' => 'required|email',
            'password' => 'required'
        ]);

        if(auth()->attempt([
            'email' => $request->email,
            'password' => $request->password
        ])){
            return redirect()->route('users.index');
        }

        return back()->with('error', 'Invalid credentials');
    }

     public function create()
    {
        return view('auth.register');
    }

    /**
     * Store a newly created resource in storage.
     */
    public function register(Request $request)
    {
        $request->validate([
            'name' => 'required',
            'email' => 'required|email|unique:users,email',
            'password' => 'required'
        ]);
        $user = User::create([
            'name' => $request->name,
            'email' => $request->email,
            'password' => $request->password
        ]);

        if($user){
            auth()->login($user);
            return redirect()->route('users.index')->with('success', 'You are logged in');
        }

        return redirect()->route('login')->with('error', 'Something went wrong');
    }

    public function logout(){
        auth()->logout();
        return redirect()->route('login');
    }
}