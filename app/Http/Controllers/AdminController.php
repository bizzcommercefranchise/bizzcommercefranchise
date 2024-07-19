<?php
namespace App\Http\Controllers\Auth;
namespace App\Http\Controllers;
namespace App\Domains\Login\Http\Controllers;

use Illuminate\Http\Request;
use App\Http\Requests\Auth\LoginRequest;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use App\Http\Controllers\Controller;
use App\Providers\RouteServiceProvider;
use Illuminate\Http\RedirectResponse;
use Illuminate\View\View;
use Illuminate\Support\Facades\Hash;
use App\Domains\Login\Models\Usercredentials;
use Illuminate\Support\Facades\Session;

class AdminController extends Controller {

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
            $url = '';
            $request->session()->regenerate();
            $data = session()->all();
            Session::put('username', $credentials['email']);
            Session::put('role_id', $user_role[0]->role_id);
            Session::put('user_id', $user[0]->user_id);
            
            if(session()->get('role_id') == 3){
                $url = '/admin/dashboard';
            } elseif(session()->get('role_id') == 1){
                $url = '/admin/dashboard';
            }
           return redirect()->intended($url);
           
//            return redirect('/dashboard');
//            return redirect('../pages/forms/products');
        } else {
            echo "Your credentials something went wrong, please try again.";
        }
    } 
    
    public function index()
    {
        return view('admin.index');
    }

    public function AdminDashboard()
    {
        return view('admin.index');
    }
    
    public function franchiseShow(): View
    {
        return view('auth.franchise-login');
    }
}
