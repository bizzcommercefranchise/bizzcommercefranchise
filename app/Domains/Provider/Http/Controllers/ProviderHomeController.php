<?php

namespace App\Domains\Login\Http\Controllers;
namespace App\Http\Controllers;
namespace App\Http\Controllers\Auth;
namespace App\Domains\Provider\Http\Controllers;

use Auth;
use Config;
use App\Domains\Product\Interfaces\ProductServiceInterface;
use App\Http\Controllers\Controller;
use App\Http\Requests\Auth\LoginRequest;
use App\Providers\RouteServiceProvider;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
//use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Response;
use Illuminate\Foundation\Auth\Access\AuthorizesRequests;
use Illuminate\View\View;
use Illuminate\Support\Facades\Hash;
use App\Domains\Login\Models\Usercredentials;
use App\Domains\Login\Models\Users;
use App\Domains\Login\Models\UserRoles;
use App\Domains\Login\Models\Franchises;
use App\Domains\Provider\Models\Providers;
use App\Domains\Provider\Models\Locations;
use App\Domains\Provider\Models\ProviderUsers;
use App\Domains\Provider\Services\ProviderService;
use Illuminate\Validation\Rules;
use App\Domains\Provider\Services\ProviderUserService;
use App\Domains\Provider\Services\LocationService;
use App\Domains\Franchise\Services\FranchiseService;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Session;
use App\Domains\Provider\Interfaces\ProviderServiceInterface;
use App\Domains\Provider\Interfaces\ProviderUserServiceInterface;
use App\Domains\Provider\Interfaces\LocationServiceInterface;
use App\Domains\Franchise\Interfaces\FranchiseServiceInterface;
use App\Repositories\Repository;
use Illuminate\Support\Facades\Password;

class ProviderHomeController extends Controller
{
    public $franchiseService;
    public $providerService;
    public $locationService;
    protected $model;
    protected $model2;
    protected $model3;
    protected $model4;  
    protected $model5;  
    protected $model6;  
    public function __construct(FranchiseServiceInterface $franchiseService,ProviderServiceInterface $providerService,LocationServiceInterface $locationService,Providers $providers,Users $users,UserRoles $roles,Usercredentials $usercredentials, ProviderUsers $provideruser, Locations $locations)
    {
        $this->franchiseService = $franchiseService;
        $this->providerService = $providerService;
        $this->locationService = $locationService;
        $this->model = new Repository($providers);
        $this->model2 = new Repository($users);
        $this->model3 = new Repository($roles);
        $this->model4 = new Repository($usercredentials);    
        $this->model5 = new Repository($provideruser);    
        $this->model6 = new Repository($locations);    
    }
    /**
     * Display the login view.
     */
    public function showLoginForm(): View
    {
        return view('auth.provider-login');
    }
    public function show(): View
    {
        $franchiseList = $this->franchiseService->getCompleteList();
        $id = Session::get('franchiseid');
        $providerList = DB::table('providers')
            ->where('franchise_id', $id)->get(); 
//        $providerList = $this->providerService->getCompleteList();
        return view('home.provider.homeProviderList',['providers' => $providerList,'franchises' => $franchiseList]);        
    }
    public function showLocations(): View
    {
        $locationsList = $this->locationService->getCompleteList();
        return view('home.provider.homeLocationList', ['locations' => $locationsList]);
    }
    public function create():View
    {
       $franchiseList = $this->franchiseService->getCompleteList();
       $locationsList = $this->locationService->getCompleteList();
       return view('provider.homeProviderRegister',['franchises' => $franchiseList,'locations' => $locationsList]); 
    }
    public function createLocation():View
    {
        $locationList = $this->locationService->getCompleteList();
        return view('provider.locationRegister', ['locations' => $locationList]);
    }
    public function providerStore(Request $request)
    {
        if(!isset($request->name) || empty($request->name)){
            echo "Please enter provider name";
            return false;
        }elseif(!isset($request->first_name) || empty($request->first_name)){
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
        $user_id = Session::get('user_id');
        $role_id = $request->role_id;
        $franchise_id = null;
        if(!empty($user_id)){
            $user = DB::table('users')
                    ->where('id', '=', $user_id)
                    ->get();  
            if(count($user) > 0){
             $franchise_id = $user[0]->franchise_id;
            }
        } else {
            $franchise_id = null;
        }
        if(!empty($user_id)){
            $createdby =  Session::get('user_id');
        } else {
            $createdby = null;
        }
        $request->validate([
            'name' => ['required', 'string', 'max:255'],
            'first_name' => ['required', 'string', 'max:255'],
            'last_name' => ['required', 'string', 'max:255'],
            'email' => ['required', 'string', 'max:255'],
            'password' => ['required', 'confirmed', Rules\Password::defaults()]
        ]);
        $data = array(
            'franchise_id' => $franchise_id,
            'name' => $request->name,
            'email' => $request->email,
            'location_id' => $request->location_id
        );
        $providerArray = $this->model->create($data);
        
        $data = array(
            'franchise_id' => $providerArray['franchise_id'],
            'first_name' => $request->first_name,
            'last_name' => $request->last_name,
            'email' => $request->email,
            'primary_provider_id' => $providerArray['id'],
            'created_by' => $user_id
        );
        try 
        {
            if($providerArray['id'] !== ""){
                $userArray = $this->model2->create($data);
                try 
                {
                    if($providerArray['id'] !== "" && $userArray['id'] !== ""){
                        $data = array(
                            'user_id' => $userArray['id'],
                            'provider_id' => $providerArray['id'],
                            'name' => $request->name,
                            'email' => $request->email,
                        );
                        $providerUserArray = $this->model5->create($data);
//                        print_r($providerUserArray); exit;
                    }
                } catch(Exception $e) {
                    return $e->getMessage(); 
                }
                try 
                {
                    if($userArray['id'] !== ""){
                        $rolesData = array(
                            'user_id' => $userArray['id'],
                            'provider_id' => $providerArray['id'],
                            'role_id' => $role_id,
                            'created_by' => $createdby
                        );
                        $rolesArray = $this->model3->create($rolesData);

                        $userCredentials = array(
                            'franchise_id' => $providerArray['franchise_id'],                  
                            'username' => $request->email,
                            'password' => md5($request->password),
                            'user_id' => $userArray['id'],
                            'created_by' => $createdby);

                        $credentialsResult = $this->model4->create($userCredentials); 
                        echo "Provider saved successfully.";
                    }
                } catch(Exception $e) {
                    throw new Exception($credentialsResult);
                }
            }
      } catch(Exception $e) {
         throw $e;
      }        
//        $providerArray = $this->providerService->saveProviderList($data);
    }
    public function locationStore(Request $request)
    {
        try
        {
            if(!isset($request->name) || empty($request->name)){
                echo "Please enter name";
                return false;
            }elseif(!isset($request->address) || empty($request->address)){
                echo "Please enter address";
                return false;
            }elseif(!isset($request->city) || empty($request->city)){
                echo "Please enter city";
                return false;
            }elseif(!isset($request->state) || empty($request->state)){
                echo "Please enter state";
                return false;
            }elseif(!isset($request->country) || empty($request->country)){
                echo "Please enter country";
                return false;
            }elseif(!isset($request->postal_code) || empty($request->postal_code)){
                echo "Please enter password postal code";
                return false;
            }    
            $request->validate([
                'name' => ['required', 'string', 'max:255'],
                'address' => ['required', 'string', 'max:255'],
                'city' => ['required', 'string', 'max:255'],
                'state' => ['required', 'string', 'max:255'],
                'country' => ['required', 'string', 'max:255'],
                'postal_code' => ['required', 'string', 'max:255']
            ]);

            $data = array(
                'name' => $request->name,
                'address' => $request->address,
                'city' => $request->city,
                'state' => $request->state,
                'country' => $request->country,
                'postal_code' => $request->postal_code,
            );
            $locationArray = $this->locationService->saveLocationList($data);
            echo "Location saved successfully.";
        } catch(Exception $e) {
         throw $e;
        }        
    }
    public function edit(Request $request): View
    {
        $id = $request->id;
//        $userShow = $this->loginService->getById($id);
        $providerShow = DB::table('providers')
                    ->select('providers.id','providers.name','providers.location_id','users.email','users.first_name','users.last_name','user_credentials.password')
                    ->leftJoin('provider_users','providers.id','=','provider_users.provider_id')
                    ->leftJoin('franchises','providers.franchise_id','=','franchises.id')
                    ->leftJoin('users','provider_users.user_id','=','users.id')
                    ->leftJoin('user_credentials','provider_users.user_id','=','user_credentials.user_id')
                    ->where('providers.id', '=', $id)
                    ->first();
        $providerList = $this->providerService->getCompleteList();
        $franchiseList = $this->franchiseService->getCompleteList();
        $locationList = $this->locationService->getCompleteList();
        return view('home.provider.editHomeProvider',['providershow' => $providerShow,'providers' => $providerList,'franchises' => $franchiseList,'locations' => $locationList]);
    }
    public function editLocation(Request $request): View
    {
        $id = $request->id;
        $locationList = $this->locationService->getById($id);
        return view('home.provider.editLocation', ['locations' => $locationList]);
    }
    public function update(Request $request, $id)
    {
        if(!isset($request->provider_name) || empty($request->provider_name)){
            echo "Please enter provider name";
            return false;
        }elseif(!isset($request->name) || empty($request->name)){
            echo "Please enter first name";
            return false;
        }elseif(!isset($request->last_name) || empty($request->last_name)){
            echo "Please enter first last name";
            return false;
        }elseif(!isset($request->location_id) || empty($request->location_id)){
            echo "Please select location";
            return false;
        }elseif(!isset($request->email) || empty($request->email)){
            echo "Please enter email";
            return false;
        }        
        $providersArray = DB::table('providers')
                            ->where('id', $id)->get();
        try
        {
            if(isset($request->provider_name) || isset($request->name) || isset($request->last_name) || isset($request->location_id)
                    || isset($request->email) ){

            $providerArray = array(
                'name' => $request->provider_name,
                'location_id' => $request->location_id,
                'email' => $request->email
            );
            $providerRow = DB::table('providers')
                        ->where('id', $id)
                        ->update($providerArray);

            $providerUsers = DB::table('provider_users')
                ->where('provider_id', $id)->get();
            $data = array(
                'provider_id' => $id,
                'name' => $request->provider_name,
                'email' => $request->email,
            );

            $providerUser = DB::table('provider_users')
                        ->where('provider_id', $id)
                        ->update($data);

            $userArray = array(
               'first_name' => $request->name,
               'last_name' => $request->last_name,
               'email' => $request->email
            );

            $updateRow = DB::table('users')
                        ->where('id', $providerUsers[0]->user_id)
                        ->update($userArray);
            }
            if(isset($request->password) || isset($request->email)){
                $password = md5($request->password);
                $userData = array(
                    'username' => $request->email,
                    'password' => $password,
                );
                $updateRow = DB::table('user_credentials')
                        ->where('user_id', $providerUsers[0]->user_id)
                        ->update($userData);

                $providerArr = array(
                    'provider_id' => $id,
                    'name' => $request->provider_name,
                    'email' => $request->email);
                $updateProvider = DB::table('provider_users')
                        ->where('user_id', $providerUsers[0]->user_id)
                        ->update($providerArr);            

            }         
/*        $providerArray = array(
            'franchise_id' => $request->franchise_id,
            'name' => $request->name,
            'email' => $request->email
        );*/   
//        $this->providerService->update($providerArray, $id);
        echo "Updated provider successfully";
        } catch(Exception $e) {
         throw $e;
        }  
    }
    public function updateLocation(Request $request, $id)
    {
        try
        {
           if(!isset($request->name) || empty($request->name)){
               echo "Please enter name";
               return false;
           }elseif(!isset($request->address) || empty($request->address)){
               echo "Please enter address";
               return false;
           }elseif(!isset($request->city) || empty($request->city)){
               echo "Please enter city";
               return false;
           }elseif(!isset($request->state) || empty($request->state)){
               echo "Please enter state";
               return false;
           }elseif(!isset($request->country) || empty($request->country)){
               echo "Please enter country";
               return false;
           }elseif(!isset($request->postal_code) || empty($request->postal_code)){
               echo "Please enter password postal code";
               return false;
           }         
           $locationArray = array(
                'name' => $request->name,
                'address' => $request->address,
                'city' => $request->city,
                'state' => $request->state,
                'country' => $request->country,
                'postal_code' => $request->postal_code,
           );   
           $this->locationService->update($locationArray, $id);
           echo "Updated location successfully"; 
        } catch(Exception $e) {
         throw $e;
        }          
    }
    public function destroy($id):View
    {
        $this->providerService->delete($id);
        $franchiseList = $this->franchiseService->getCompleteList();
        $providerList = $this->providerService->getCompleteList();
        return view('home.provider.homeProviderList',['providers' => $providerList,'franchises' => $franchiseList]);        
    }
    public function destroyLocation($id):View
    {
        $this->locationService->delete($id);
        $locationList = $this->locationService->getCompleteList();
        return view('home.provider.homeLocationList', ['locations' => $locationList]);
    }
    public function providerCheck()
    {
        $name = null;
        $host = request()->getHttpHost();
        $host_name = explode('.', $host);
        if(count($host_name) > 0){
            $name = $host_name[0];
        }
        $extension = "bizzcommerce.localhost";
        $franchiseList = $this->franchiseService->getCompleteList();
        $locationList = $this->locationService->getCompleteList();
        $providerList = $this->providerService->getCompleteList();
        $url = "";
        $businessunit_url = "";
        foreach($franchiseList as $franchise){
            $title = $franchise->name;
            $franchise_title = strtolower(trim($title)); 
            $replace_franchise_title = str_replace("'", "", $franchise_title);
            $franchise_name = str_replace(" ", "", $replace_franchise_title);
            if($name == $franchise_name){
                $url = $franchise_name.".".$extension;
            } else {
                foreach($providerList as $provider){
                    $title = $provider->name;
                    $provider_title = strtolower(trim($title)); 
                    $replace_provider_title = str_replace("'", "", $provider_title);
                    $provider_name = str_replace(" ", "", $replace_provider_title);
                    $provider_location_id = $provider->location_id;
                    foreach($locationList as $location){
                        $title = $location->name;
                        $location_title = strtolower(trim($title)); 
                        $replace_location_title = str_replace("'", "", $location_title);
                        $location_name = str_replace(" ", "", $replace_location_title);
                        $location_id = $location->id;
                        if($location_id == $provider_location_id){
                            $location_name = substr($location_name, 0, 3);
                            $businessunit_location_name = $provider_name.$location_name;
                        }
                        if($name == $businessunit_location_name){
                            Session::put('enduserFranchiseId', $franchise->id);
                            Session::put('enduserProviderId', $provider->id);
                            $businessunit_url = $businessunit_location_name.".".$extension; 
                        }
                    }
                }
            }
            if($host == $url)
            {
              return view('home.provider.loginHome');
            }elseif($host == $businessunit_url){
              return view('home.enduser.loginHome');
            }
        }
        echo "You are not authorise to access this url, please try again latter."; 
    }
   
    public function providerLogin(): View
    {
        return view('home.proivder.loginHome');
    }
    /**
     * Handle an incoming authentication request.
     */
    public function providerHomeStore(Request $request)
    {
//        $request->authenticate();
//        $request->session()->regenerate();
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
        $franchiseId = $users[0]->franchise_id;
        
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
                $data = session()->all();
                Session::put('username', $credentials['email']);
                Session::put('franchiseid', $user[0]->franchise_id);
                Session::put('role_id', $user_role[0]->role_id);
                Session::put('user_id', $user[0]->user_id);
                Session::put('provider_id', $provider[0]->id);
//                echo session()->get('role_id'); exit;
                
                if(session()->get('role_id') == 2){
                    $url = '/providerHome/dashboard';
                } elseif(session()->get('role_id') == 1 || session()->get('role_id') == 3 || session()->get('role_id') == 4){
                   echo "You are not authorised person to access this url"; exit;
                } 
               return redirect()->intended($url);
            } else {
                echo "Your credentials something went wrong, please try again.";
            }
        } catch(Exception $e) {
         throw $e;
        }        
    }
    public function endUserHomeStore(Request $request)
    {
//        $request->authenticate();
//        $request->session()->regenerate();
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
        $franchiseId = $users[0]->franchise_id;
        
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
                $data = session()->all();
                Session::put('username', $credentials['email']);
                Session::put('franchiseid', $user[0]->franchise_id);
                Session::put('role_id', $user_role[0]->role_id);
                Session::put('user_id', $user[0]->user_id);
                Session::put('provider_id', $provider[0]->id);
//                echo session()->get('role_id'); exit;
                
                if(session()->get('role_id') == 2){
                    $url = '/enduserHome/dashboard';
                } elseif(session()->get('role_id') == 1){
                   echo "You are not authorised person to access this url"; exit;
                } 
               return redirect()->intended($url);
            } else {
                echo "Your credentials something went wrong, please try again.";
            }
        } catch(Exception $e) {
         throw $e;
        }        
    }
    public function providerHome(Request $request):View
    {
        $user_id = session()->get('user_id');
        
        $franchise = DB::table('users')->where('id', $user_id)->get();
        $franchise_id = $franchise[0]->franchise_id;
        $provider_id = $franchise[0]->primary_provider_id; 
       
         Session::put('provider_id', $provider_id);

//      $category = DB::table('products')->where('id', $user_id)->get(); 
        
        $products = DB::table('products')->where('franchise_id', $franchise_id)
                ->where('provider_id', $provider_id)
                ->get();
              
        return view('dashboard_home', ['providerProducts' => $products]);        
    }
    public function userHomeStore(Request $request)
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
        $franchiseId = $users[0]->franchise_id;
        
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
                $data = session()->all();
                Session::put('username', $credentials['email']);
                Session::put('franchiseid', $user[0]->franchise_id);
                Session::put('role_id', $user_role[0]->role_id);
                Session::put('user_id', $user[0]->user_id);
                Session::put('provider_id', $provider[0]->id);
//                echo session()->get('role_id'); exit;
                
                if(session()->get('role_id') == 2){
                    $url = '/providerHome/dashboard';
                } elseif(session()->get('role_id') == 1){
                   echo "You are not authorised person to access this url"; exit;
                } 
               return redirect()->intended($url);
            } else {
                echo "Your credentials something went wrong, please try again.";
            }
        } catch(Exception $e) {
         throw $e;
        }        
    }
}
