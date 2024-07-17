<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Http\Requests\Auth\LoginRequest;
use App\Providers\RouteServiceProvider;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\View\View;

use App\Models\User;
use Illuminate\Support\Facades\Hash;

use App\Domains\Login\Models\Usercredentials;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Session;

class AuthenticatedSessionController extends Controller
{
    /**
     * Display the login view.
     */
    public function create(): View
    {
        return view('auth.login');
    }
    
    /**
     * Handle an incoming authentication request.
     */
    public function store(Request $request)
    {
        $request->validate([
            'email' => 'required',
            'password' => 'required',
        ]);

        $credentials = $request->only('email', 'password');
        $password = md5($credentials['password']);
        
        $user = DB::table('user_credentials')
                ->where('username', '=', $credentials['email'])
                ->where('password','=', $password)
                ->get();
        
        if(count($user) > 0){
            $user_role = DB::table('user_roles')
                    ->where('user_id', '=', $user[0]->user_id)
                    ->get();
            
            $request->session()->regenerate();
            $data = session()->all();
            Session::put('username', $credentials['email']);
            Session::put('role_id', $user_role[0]->role_id);
            if(session()->get('role_id') == 3){
                return redirect('/dashboard');
            } elseif(session()->get('role_id') == 2 || session()->get('role_id') == 4 || session()->get('role_id') == 1){
                echo "You are not authorised person to access this url"; exit;
            } 
            
        } else {
            echo "Your credentials something went wrong, please try again.";
        }
    }  

    /**
     * Destroy an authenticated session.
     */
    public function destroy(Request $request): RedirectResponse
    {
        Auth::guard('web')->logout();

        $request->session()->invalidate();

        $request->session()->regenerateToken();

        return redirect('/');
    }
}
