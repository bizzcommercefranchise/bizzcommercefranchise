<?php

namespace App\Http\Controllers\Auth;
namespace App\Http\Controllers;

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
use App\Domains\Franchise\Interfaces\FranchiseServiceInterface;
use App\Repositories\Repository;
use App\Domains\Franchise\Models\Franchise;

class FranchiseController extends Controller
{
    public $franchiseService;
    protected $model;
    protected $model2;
    protected $model3;
    protected $model4;
    public function __construct(FranchiseServiceInterface $franchiseService,Users $users,UserRoles $roles,Usercredentials $usercredentials,Franchise $franchise)
    {
        $this->franchiseService = $franchiseService;
        $this->model = new Repository($users);
        $this->model2 = new Repository($roles);
        $this->model3 = new Repository($usercredentials);
        $this->model4 = new Repository($franchise);
    }   
    
    
    public function show(): View
    {
        $franchisesList = $this->franchiseService->getCompleteList();
        return view('franchise.franchiselist',['franchises' => $franchisesList]);
    }
    
    public function edit(Request $request): View
    {
       $id = $request->id;
       $franchiseShow = DB::table('user_credentials')
                  ->select('*')
                  ->leftJoin('users','users.franchise_id','=','user_credentials.franchise_id')
                  ->leftJoin('franchises','franchises.id','=','user_credentials.franchise_id')
                  ->where('user_credentials.franchise_id', '=', $id)
                  ->first();
        return view('franchise.editfranchise',['franchiseshow' => $franchiseShow]);
    }
    
    public function update(Request $request, $id)
    {
        if(!isset($request->franchise_name) || empty($request->franchise_name)){
            echo "Please enter franchise name";
            return false;
        }elseif(!isset($request->name) || empty($request->name)){
            echo "Please enter first name";
            return false;
        }elseif(!isset($request->last_name) || empty($request->last_name)){
            echo "Please enter first last name";
            return false;
        }elseif(!isset($request->domain_name) || empty($request->domain_name)){
            echo "Please enter domain name";
            return false;
        }elseif(!isset($request->email) || empty($request->email)){
            echo "Please enter email";
            return false;
        }
        if(Session::get('role_id') == 3) 
        {
           $updatedby =  Session::get('user_id');
        } else {
           $updatedby = null;
        }
        try
        {        
            if(isset($request->franchise_name) || isset($request->name) || isset($request->domain_name) 
                      ){

                $franchiseArray = array(
                   'name' => $request->franchise_name,
                   'domain' => $request->domain_name,
                   'updated_by' => $updatedby
                );
                $updateRow = DB::table('franchises')
                        ->where('id', $id)
                        ->update($franchiseArray);            
            }
            try
            {
                if(isset($request->last_name) || isset($request->name)){
                    $users = array(                  
                        'last_name' => $request->last_name,
                        'first_name' => $request->name,
                        'email' => $request->email,
                        'updated_by' => $updatedby
                    );
                        $updateRow = DB::table('users')
                    ->where('franchise_id', $id)
                    ->update($users);  
                }
            } catch(Exception $e) {
             throw $e;
            } 
            try
            {            
                if(isset($request->email) || isset($request->password)){
                        $userCredentials = array(                  
                            'username' => $request->email,
                            'password' => md5($request->password),
                            'updated_by' => $updatedby);
                        $updateRow = DB::table('user_credentials')
                                ->where('franchise_id', $id)
                                ->update($userCredentials);

                }
                echo "Updated franchise successfully";  
            } catch(Exception $e) {
            throw $e;
           }     
        } catch(Exception $e) {
         throw $e;
        } 
    }
    
 /**
     * Display the registration view.
     */
    public function create(): View
    {
        return view('franchise.register');
    }

    /**
     * Handle an incoming registration request.
     *
     * @throws \Illuminate\Validation\ValidationException
     */
    public function store(Request $request)
    {
        if(!isset($request->franchise_name) || empty($request->franchise_name)){
            echo "Please enter franchise name";
            return false;
        }elseif(!isset($request->name) || empty($request->name)){
            echo "Please enter first name";
            return false;
        }elseif(!isset($request->last_name) || empty($request->last_name)){
            echo "Please enter first last name";
            return false;
        }elseif(!isset($request->domain_name) || empty($request->domain_name)){
            echo "Please enter domain name";
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
        $role_id = $request->role_id;
        if(Session::get('role_id') == 3) 
        {
          $createdby =  Session::get('user_id');
        } else {
            $createdby = null;
        }
        $request->validate([
            'franchise_name' => ['required', 'string', 'max:255'],
            'name' => ['required', 'string', 'max:255'],
            'last_name' => ['required', 'string', 'max:255'],
            'email' => ['required', 'string', 'lowercase', 'email', 'max:255'],
            'password' => ['required', 'confirmed', Rules\Password::defaults()],        
            'domain_name' => ['required', 'string', 'max:255']
        ]);
        $data = array(
            'name' => $request->franchise_name,
            'domain' => $request->domain_name,
            'created_by' => $createdby
        );
        $franchiseArray = $this->model4->create($data);

        $data = array(
            'franchise_id' => $franchiseArray['id'],
            'first_name' => $request->name,
            'last_name' => $request->last_name,
            'email' => $request->email,
            'primary_provider_id' => null,
            'created_by' => $createdby
        );
        try
        {        
            if($franchiseArray['id'] !== ""){
                $userArray = $this->model->create($data);
                if($userArray['id'] !== ""){
                    $rolesData = array(
                        'user_id' => $userArray['id'],
                        'provider_id' => null,
                        'role_id' => $role_id,
                        'created_by' => $createdby
                    );
                    $rolesArray = $this->model2->create($rolesData);

                    $userCredentials = array(
                        'franchise_id' => $franchiseArray['id'],                    
                        'username' => $request->email,
                        'password' => md5($request->password),
                        'user_id' => $userArray['id'],
                        'created_by' => $createdby);

                    $credentialsResult = $this->model3->create($userCredentials);
                    echo "Franchise saved successfully.";
                }
            }
        } catch(Exception $e) {
         throw $e;
        }     
    }
    
    public function destroy($id):View
    {
        $this->franchiseService->delete($id);
        $franchiseList = $this->franchiseService->getCompleteList();
        return view('franchise.franchiselist',['franchises' => $franchiseList]);
    }
    
}
