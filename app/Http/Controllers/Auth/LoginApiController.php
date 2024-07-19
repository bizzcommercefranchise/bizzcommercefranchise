<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Models\User;
use App\Providers\RouteServiceProvider;
use Illuminate\Auth\Events\Registered;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Validation\Rules;
use Illuminate\View\View;
use App\Http\Requests\Auth\LoginRequest;


class LoginApiController extends Controller
{
    /**
     * Display the registration view.
     */
    public function create(): View
    {
        return view('auth.register');
    }

    /**
     * Handle an incoming registration request.
     *
     * @throws \Illuminate\Validation\ValidationException
     */
    public function store(Request $request): RedirectResponse
    {
        $request->validate([
            'name' => ['required', 'string', 'max:255'],
            'email' => ['required', 'string', 'lowercase', 'email', 'max:255', 'unique:'.User::class],
            'password' => ['required', 'confirmed', Rules\Password::defaults()],
        ]);

        $user = User::create([
            'name' => $request->name,
            'email' => $request->email,
            'password' => Hash::make($request->password),
        ]);
        event(new Registered($user));
        Auth::login($user);
        echo "Successfully registered"; exit;
    }
    
    /**
     * Handle an incoming authentication request.
     */
    
    public function userstore(LoginRequest $request): RedirectResponse
    {
        echo "test"; exit;
//        $request->authenticate();
//
//        $request->session()->regenerate();
        
//        $url = '';
//        // print_r( $url); exit;
//        if($request->user()->role === 'admin'){
//            $url = '/admin/dashboard';
//        } elseif($request->user()->role === 'agent'){
//            $url = '/agent/dashboard';
//        } elseif($request->user()->role === 'user'){
//            $url = '/dashboard';
//        }
//echo "";
//        return redirect()->intended($url);        
    }
    
}
