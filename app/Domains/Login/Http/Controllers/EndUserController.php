<?php

namespace App\Http\Controllers\Auth;
namespace App\Http\Controllers;
namespace App\Domains\Provider\Http\Controllers;
namespace App\Domains\Login\Http\Controllers;

use Config;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Domains\Product\Interfaces\ProductServiceInterface;
use App\Domains\Login\Models\Usercredentials;
use App\Domains\Login\Models\Users;
use App\Domains\Login\Models\UserRoles;
use App\Domains\Login\Models\Franchises;
use App\Http\Requests\Auth\LoginRequest;
use App\Providers\RouteServiceProvider;
use Illuminate\Auth\Events\Registered;
use Illuminate\Http\RedirectResponse;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Validation\Rules;
use Illuminate\View\View;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Session;
use App\Domains\Franchise\Interfaces\FranchiseServiceInterface;
use App\Domains\Login\Interfaces\LoginServiceInterface;
use App\Domains\Provider\Interfaces\ProviderServiceInterface;
use App\Domains\Provider\Interfaces\ProviderUserServiceInterface;
use App\Domains\Provider\Services\ProviderUserService;
use App\Repositories\Repository;
use App\Domains\Provider\Models\Providers;
use App\Domains\Provider\Models\ProviderUsers;
use App\Domains\Provider\Services\ProviderService;


class EndUserController extends Controller
{
    public $loginService;
    public $providerService;
    public $providerUserService;
    protected $model;
    protected $model2;
    protected $model3;
    protected $model4;
    public function __construct(LoginServiceInterface $loginService,ProviderUserServiceInterface $providerUserService, ProviderServiceInterface $providerService,Users $users,UserRoles $roles,Usercredentials $usercredentials, ProviderUsers $providerusers)
    {
        $this->loginService = $loginService;
        $this->providerService = $providerService;        
        $this->providerUserService = $providerUserService;        
        $this->model = new Repository($users);
        $this->model2 = new Repository($roles);
        $this->model3 = new Repository($usercredentials);
        $this->model4 = new Repository($providerusers);
    }     
    public function create()
    {
        return view('home.enduser.register');       
    }
    public function store(Request $request)
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
            echo "Please enter password confirmation";
            return false;
        }
        $franchise_id = null;
        $provider = null;

        $request->validate([
            'name' => ['required', 'string', 'max:255'],
            'last_name' => ['required', 'string', 'max:255'],
            'email' => ['required', 'string', 'lowercase', 'email', 'max:255']
        ]);
        $franchise = Session::get('enduserFranchiseId');
        $provider = Session::get('enduserProviderId');
        try
        {
            if(isset($request->provider_id) || !empty($provider)){
                $provider = Session::get('enduserProviderId');
            }
            if(isset($request->franchise_id) || !empty($franchise)){
                $franchise = Session::get('enduserFranchiseId');
            }
            $data = array(
                'first_name' => $request->name,
                'last_name' => $request->last_name,
                'email' => $request->email,
                'primary_provider_id' => $provider,
                'franchise_id' => $franchise
            );
            $userArray = $this->model->create($data);
            try
            {
                if($userArray['id'] !== ""){
                    $rolesData = array(
                        'user_id' => $userArray['id'],
                        'provider_id' => $provider,
                        'role_id' => 1      
                    ); 
                    $rolesArray = $this->model2->create($rolesData); 

                     $userCredentials = array(
                        'username' => $request->email,
                        'password' => md5($request->password),
                        'franchise_id' => $franchise,
                        'user_id' => $userArray['id']);
                    $credentialsResult = $this->model3->create($userCredentials);

                     $providerArr = array(
                        'user_id' => $userArray['id'],                 
                        'provider_id' => $provider,
                        'name' => $request->name,
                        'email' => $request->email);
                    $result = $this->model4->create($providerArr);            
                    echo "User saved successfully.";
                }
            } catch(Exception $e) {
               throw $e;
            }     
        } catch(Exception $e) {
         throw $e;
        }             
    }
    public function enduserHome(Request $request):View
    {
        if(session()->get('user_id') != null){
            $user_id = session()->get('user_id');
            $franchise_id = null;
            $provider_id = null;
            $franchise = DB::table('users')->where('id', $user_id)->get();
            if(count($franchise) > 0){
                $franchise_id = $franchise[0]->franchise_id;
                $provider_id = $franchise[0]->primary_provider_id;
            }
    //      $category = DB::table('products')->where('id', $user_id)->get(); 

            $products = DB::table('products')->where('franchise_id', $franchise_id)
                            ->where('provider_id', $provider_id)
                            ->get();

            return view('home.enduser.productsHome', ['products' => $products]);
        } else {
          return view('home.enduser.loginHome');
        }        
    }
    public function endUserHomeStore(Request $request)
    {
        if(!isset($request->email) || empty($request->email)){
            echo "Please enter email";
            return false;
        }elseif(!isset($request->password) || empty($request->password)){
            echo "Please enter password";
            return false;
        }
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
        
        $users = DB::table('users')
                    ->where('email', '=', $credentials['email'])
                    ->get();
        if(count($users) > 0 && !empty($users[0]->franchise_id)){
          $franchiseId = $users[0]->franchise_id;
        } else {
          $franchiseId = null;
        }
        $provider_id = null;
        try 
        {
            if(count($user) > 0){
                $user_role = DB::table('user_roles')
                        ->where('user_id', '=', $user[0]->user_id)
                        ->get();
                $provider = DB::table('providers')
                        ->where('franchise_id', '=', $user[0]->franchise_id)
                        ->get();
                $url = '';
                $request->session()->regenerate();
    //$id = Auth::id();
                if(count($provider) > 0){
                    $provider_id = $provider[0]->id;
                }
                $data = session()->all();
                Session::put('username', $credentials['email']);
                Session::put('role_id', $user_role[0]->role_id);              
                Session::put('user_id', $user[0]->user_id);
                Session::put('franchiseid', $franchiseId); 
                Session::put('provider_id', $provider_id);
                if($franchiseId !="" || $provider_id !=""){
                    if(session()->get('role_id') == 1){
                       $url = '/enduserHome/dashboard';
                    } elseif(session()->get('role_id') == 2 || session()->get('role_id') == 4 || session()->get('role_id') == 3){
                       echo "You are not authorised person to access this url"; exit;
                    } 
                   return redirect()->intended($url);
                } else {
                  echo "Some thing went wrong please try again."; exit;
                } 
            } else {
                echo "Your credentials something went wrong, please try again.";
            }
        } catch(Exception $e) {
          throw $e;
        }
    }
    public function profileEdit(Request $request):View
    {
        $id = $request->id;
        $usersList = $this->loginService->getById($id);
        return view('home.enduser.edituser', ['users' => $usersList]);
    }
    public function endUserUpdate(Request $request, $id)
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
        } 
        $provider = null;
        if(Session::get('provider_id') !=null){   
            $provider = Session::get('provider_id');
        }
        try
        {
            if(isset($request->name) || isset($request->last_name) 
                    || isset($request->email) ){
            $userArray = array(
               'first_name' => $request->name,
               'last_name' => $request->last_name,
               'email' => $request->email,
            //    'primary_provider_id' =>$provider
            );

            $updateRow = DB::table('users')
                        ->where('id', $id)
                        ->update($userArray);
            }
            try
            {
                if(isset($request->password)){
                    $password = md5($request->password); 
                    $userData = array(
                        'username' => $request->email,
                        'password' => $password,
                    );
                    $updateRow = DB::table('user_credentials')
                            ->where('user_id', $id)
                            ->update($userData);

                    $providerArr = array(
                        'provider_id' =>$provider,
                        'name' => $request->name,
                        'email' => $request->email);
        //            print_r($providerArr); exit;
                    $updateProvider = DB::table('provider_users')
                            ->where('user_id', $id)
                            ->update($providerArr);            

                }  
                echo "Updated user successfully"; 
            } catch(Exception $e) {
            throw $e;
           } 
        } catch(Exception $e) {
         throw $e;
        }         
    }    
}
            