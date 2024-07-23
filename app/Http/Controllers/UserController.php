<?php
namespace App\Http\Controllers\Auth;
namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use App\Domains\Login\Models\Usercredentials;
use App\Domains\Login\Models\Users;
use App\Domains\Login\Models\UserRoles;
use App\Domains\Login\Models\Franchises;
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
use App\Domains\Franchise\Interfaces\FranchiseServiceInterface;
use App\Domains\Login\Interfaces\LoginServiceInterface;
use App\Domains\Provider\Interfaces\ProviderServiceInterface;
use App\Domains\Provider\Interfaces\ProviderUserServiceInterface;
use App\Domains\Provider\Services\ProviderUserService;
use App\Repositories\Repository;
use App\Domains\Provider\Models\Providers;
use App\Domains\Provider\Models\ProviderUsers;
use App\Domains\Provider\Services\ProviderService;

class UserController extends Controller
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
    
    public function index(): View
    {
        //
    }
    public function show(): View
    {
        $userList = $this->loginService->getCompleteList();
        return view('user.userlist',['users' => $userList]);
    }
    public function providerUserShow():View
    {
         $provider = Session::get('provider_id'); 
         $userShow = array();
//       $providerUserList = $this->providerUserService->getById($provider);
        $users = DB::table('users')
                ->select('*')
                ->where('users.primary_provider_id', '=', $provider)
                ->first();
        if(empty($users)){
             $userShow = null;
        } else {
            $query = "select a.id,a.primary_provider_id,a.email as useremail,a.first_name,a.last_name,b.id as providerid from users as a 
            left join providers as b on a.primary_provider_id=b.id 
            where a.primary_provider_id=$provider and a.id !=$users->id";

            $userShow = DB::select($query);
        }
            // echo Session::get('user_id'); exit;
        //    print_r($userShow); exit;
        return view('home.provider.userlist', ['users' => $userShow]);

    }    
    public function create(): View
    {
        $providerList = $this->providerService->getCompleteList();
        return view('user.register',['providers' => $providerList]);
    }
    public function providerUserCreate(): View
    {
        $providerList = $this->providerService->getCompleteList();
        return view('home.provider.userRegister',['providers' => $providerList]);
    }
    public function edit(Request $request): View
    {
        $id = $request->id;
//        $userShow = $this->loginService->getById($id);
        $userShow = DB::table('user_credentials')
                    ->select('*')
                    ->leftJoin('users','users.id','=','user_credentials.user_id')
                    ->leftJoin('user_roles','user_roles.user_id','=','user_credentials.user_id')
                    ->where('user_credentials.user_id', '=', $id)
                    ->first();
        $providerList = $this->providerService->getCompleteList();        
        return view('user.edituser',['usershow' => $userShow,'providers' => $providerList]);
    }
    public function providerUseredit(Request $request): View
    {
        $id = $request->id;
//        $userShow = $this->loginService->getById($id);
        $userShow = DB::table('user_credentials')
                    ->select('*')
                    ->leftJoin('users','users.id','=','user_credentials.user_id')
                    ->leftJoin('user_roles','user_roles.user_id','=','user_credentials.user_id')
                    ->where('user_credentials.user_id', '=', $id)
                    ->first();
        $providerList = $this->providerService->getCompleteList();        
        return view('home.provider.edituser',['usershow' => $userShow,'providers' => $providerList]);
    }    
    public function update(Request $request, $id)
    {
        
        if(isset($request->name) || isset($request->last_name) 
                || isset($request->email) ){
        $userArray = array(
           'first_name' => $request->name,
           'last_name' => $request->last_name,
           'email' => $request->email,
           'primary_provider_id' =>$request->provider_id
        );
        
//        $updatedRow = $this->loginService->update($userArray, $id);
        $updateRow = DB::table('users')
                    ->where('id', $id)
                    ->update($userArray);
        }
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
                'provider_id' =>$request->provider_id,
                'name' => $request->name,
                'email' => $request->email);
//            print_r($providerArr); exit;
            $updateProvider = DB::table('provider_users')
                    ->where('user_id', $id)
                    ->update($providerArr);            
              
        }  
        echo "Updated user successfully";
    }
    public function providerUserUpdate(Request $request, $id)
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
        $provider = Session::get('provider_id'); 
        try
        {
            if(isset($request->name) || isset($request->last_name) 
                    || isset($request->email) ){
            $userArray = array(
               'first_name' => $request->name,
               'last_name' => $request->last_name,
               'email' => $request->email,
               'primary_provider_id' =>$provider
            );

    //        $updatedRow = $this->loginService->update($userArray, $id);
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
    public function store(Request $request)
    {
        
        $request->validate([
            'name' => ['required', 'string', 'max:255'],
            'last_name' => ['required', 'string', 'max:255'],
            'email' => ['required', 'string', 'lowercase', 'email', 'max:255']
        ]);
        if(isset($request->provider_id) || !empty($request->provider_id)){
            $provider = $request->provider_id;
        } else {
            $provider = null;
        }
        $data = array(
            'first_name' => $request->name,
            'last_name' => $request->last_name,
            'email' => $request->email,
            'primary_provider_id' => $provider
        );
        $userArray = $this->model->create($data);
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
                'franchise_id' => null,
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
//        $result = $this->loginService->saveUserList($data);
        
    }
    public function providerUserStore(Request $request)
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
        $provider = Session::get('provider_id'); 
        $request->validate([
            'name' => ['required', 'string', 'max:255'],
            'last_name' => ['required', 'string', 'max:255'],
            'email' => ['required', 'string', 'lowercase', 'email', 'max:255']
        ]);
        try 
        {        
            if(isset($request->provider_id) || !empty($provider)){
                $provider = Session::get('provider_id'); 
            } else {
                $provider = null;
            }
            $data = array(
                'first_name' => $request->name,
                'last_name' => $request->last_name,
                'email' => $request->email,
                'primary_provider_id' => $provider
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
                        'franchise_id' => null,
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
    public function destroy($id):View
    {
        $this->loginService->delete($id);
        $userList = $this->loginService->getCompleteList();
        return view('user.userlist',['users' => $userList]);
    }
    public function providerDestroy($id):View
    {
        $provider = Session::get('provider_id');     
        $this->loginService->delete($id);
        $query = "select a.id,a.primary_provider_id,a.email as useremail,a.first_name,a.last_name,b.id as providerid from users as a 
        left join providers as b on a.primary_provider_id=b.id 
        where a.primary_provider_id=$provider";

        $userShow = DB::select($query);       
       return view('home.provider.userlist', ['users' => $userShow]);
    }
    
}
