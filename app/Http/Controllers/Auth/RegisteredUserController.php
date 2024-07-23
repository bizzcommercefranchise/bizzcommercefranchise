<?php

namespace App\Http\Controllers\Auth;


use App\Http\Controllers\Controller;
use App\Models\User;
use App\Domains\Login\Models\Usercredentials;
use App\Domains\Login\Models\Users;
use App\Domains\Login\Models\UserRoles;
use App\Http\Requests\Auth\LoginRequest;
use App\Providers\RouteServiceProvider;
use Illuminate\Auth\Events\Registered;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Validation\Rules;
use Illuminate\View\View;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Session;

class RegisteredUserController extends Controller
{
    /**
     * Display the registration view.
     */
    public function create(): View
    {
        if(session()->get('user_id') != null){
            return view('auth.register');
        } else {
            return view('admin/dashboard');
        }


    }

    /**
     * Handle an incoming registration request.
     *
     * @throws \Illuminate\Validation\ValidationException
     */
    public function store(Request $request): RedirectResponse
    {
        if(!isset($request->name) || empty($request->name)){
            echo "Please enter first name";
            return false;
        }elseif(!isset($request->last_name) || empty($request->last_name)){
            echo "Please enter first last name";
            return false;
        }elseif(!isset($request->email) || empty($request->email)){
            echo "Please enter email";
            return false;
        }elseif(!isset($request->password) || empty($request->password)){
            echo "Please enter password";
            return false;
        }elseif(!isset($request->password_confirmation) || empty($request->password_confirmation)){
            echo "Please enter confirm password";
            return false;
        }        
        $request->validate([
            'name' => ['required', 'string', 'max:255'],
            'email' => ['required', 'string', 'lowercase', 'email', 'max:255'],
            'password' => ['required', 'confirmed', Rules\Password::defaults()],
        ]);

        $users = Users::create([
            'first_name' => $request->name,
            'last_name' => $request->last_name,
            'email' => $request->email,
        ]);
        try
        {
            if($users){
                $user_role = UserRoles::create([
                    'user_id' => $users->id,
                    'role_id' => 3
                ]);
                $user = Usercredentials::create([
                    'username' => $request->email,
                    'password' => md5($request->password),
                    'franchise_id' => null,
                    'user_id' => $users->id,
                ]);
            }

            event(new Registered($user));

    //        Auth::login($user);

            $user = DB::table('user_credentials')
                    ->where('username', '=', $request->email)
                    ->where('password','=', md5($request->password))
                    ->get();
            try
            {
                if(count($user) > 0){
                    $user_role = DB::table('user_roles')
                            ->where('user_id', '=', $user[0]->user_id)
                            ->get();

                    $request->session()->regenerate();
                    $data = session()->all();
                    Session::put('username', $request->email);
                    Session::put('role_id', $user_role[0]->role_id);
                    Session::put('user_id', $user[0]->user_id);
                    if(session()->get('role_id') == 3){   
                        return redirect(RouteServiceProvider::HOME);
                    } elseif(session()->get('role_id') == 1 || session()->get('role_id') == 2 || session()->get('role_id') == 4) {
                        echo "You are not authorised person to access this url"; exit;
                    }
                }
            } catch(Exception $e) {
                throw $e;
            }   
        } catch(Exception $e) {
         throw $e;
        }         
    }
    public function customerStore(Request $request): RedirectResponse
    {
        $user = "";
        $request->validate([
            'name' => ['required', 'string', 'max:255'],
            'email' => ['required', 'string', 'lowercase', 'email', 'max:255', 'unique:'.User::class],
            'password' => ['required', 'confirmed', Rules\Password::defaults()],
        ]);
        $company = $request->company;
        $franchise = $request->franchise;
        $customerFranchiseNameCheck = DB::table('users')->where([
                                        'companyName' => $company
                                        ])->get();
        $count = count($customerFranchiseNameCheck);
        $user = User::where('companyName', '=', $company)->exists();
//        print_r($user); exit;
        if ( $user !=0 || $user === null) {
            $user = User::create([
                'name' => $request->name,
                'email' => $request->email,
                'password' => Hash::make($request->password),
                'companyName' => $company,
                'franchiseId' => $franchise
            ]);
            event(new Registered($user));
//            Auth::login($user);
            $url = '/franchise/franchise-show/'.$company;
            return redirect()->intended($url); 
        
        } else {
            echo "Company name already exists, please try again with another name"; exit;
        }
       
        $url = '/franchise/franchise-show/'.$company;
        return redirect()->intended($url); 
      
    }
        /**
     * Display the franchise customer registration view.
     */
    public function franchiseCustomerCreate(): View
    {
        return view('auth.franchise-register');
    }
}
