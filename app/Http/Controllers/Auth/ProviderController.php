<?php
namespace App\Domains\Login\Http\Controllers;
namespace App\Http\Controllers;
namespace App\Http\Controllers\Auth;

use Config;
//use Auth;
use App\Http\Controllers\Controller;
use App\Http\Requests\Auth\LoginRequest;
use App\Providers\RouteServiceProvider;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\View\View;
use Illuminate\Support\Facades\Hash;
use App\Domains\Login\Models\Usercredentials;
use App\Domains\Login\Models\Users;
use App\Domains\Login\Models\UserRoles;
use App\Domains\Login\Models\Franchises;
use App\Domains\Provider\Models\Providers;
use App\Domains\Provider\Services\ProviderService;
use App\Domains\Franchise\Services\FranchiseService;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Session;
use App\Domains\Provider\Interfaces\ProviderServiceInterface;
use App\Domains\Franchise\Interfaces\FranchiseServiceInterface;
use App\Repositories\Repository;
use Illuminate\Support\Facades\Response;
use Illuminate\Support\Facades\Password;

class ProviderController extends Controller
{
    public $franchiseService;
    public $providerService;
    public function __construct(FranchiseServiceInterface $franchiseService,ProviderServiceInterface $providerService,Providers $providers)
    {
        $this->franchiseService = $franchiseService;
        $this->providerService = $providerService;
        $this->model = new Repository($providers);
    }
    /**
     * Display the login view.
     */
    public function showLoginForm(): View
    {
        return view('auth.provider-login');
    } 
    /**
     * Handle an incoming authentication request.
     */
    public function store(Request $request)
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
        try 
        {
            if(count($user) > 0){
                $user_role = DB::table('user_roles')
                        ->where('user_id', '=', $user[0]->user_id)
                        ->get();
                $url = '';
                $request->session()->regenerate();               
    //$user = Auth::user();
    //$id = Auth::id();
                $data = session()->all();
                Session::put('username', $credentials['email']);
                Session::put('role_id', $user_role[0]->role_id);
                Session::put('user_id', $user[0]->user_id);
                if(session()->get('role_id') == 3){
                    $url = '/admin/dashboard';
                } elseif(session()->get('role_id') == 1){
                   echo "You are not authorised person to access this url"; exit;
                } elseif(session()->get('role_id') == 2){
                    $url = '/provider/dashboard';
                }else{
                 echo "You are not authorised person to access this url"; exit;
                } 
               return redirect()->intended($url);

    //            return redirect('/dashboard');
    //            return redirect('../pages/forms/products');
            } else {
                echo "Your credentials something went wrong, please try again.";
            }
        } catch(Exception $e) {
         throw $e;
        }  
    }      
    
    public function showProducts(Request $request): View
    {
        $user_id = session()->get('user_id');
        $franchise = DB::table('users')->where('id', $user_id)->get();
        $franchise_id = $franchise[0]->franchise_id;
        $provider_id = $franchise[0]->primary_provider_id;
        
//      $category = DB::table('products')->where('id', $user_id)->get(); 
        
        $products = DB::table('products')->where('franchise_id', $franchise_id)
                ->where('provider_id', $provider_id)
                ->get();
              
        return view('dashboard', ['providerProducts' => $products]);      
    }
    public function show(): View
    {
        $franchiseList = $this->franchiseService->getCompleteList();
        $providerList = $this->providerService->getCompleteList();
        return view('provider.providerlist',['providers' => $providerList,'franchises' => $franchiseList]);        
    }
    public function create():View
    {
       $franchiseList = $this->franchiseService->getCompleteList();
       return view('provider.register',['franchises' => $franchiseList]); 
    }
    public function providerStore(Request $request)
    {
        $request->validate([
//            'franchise_id' => ['required'],
            'name' => ['required', 'string', 'max:255'],
            'email' => ['required', 'string', 'max:255']
        ]);

        $data = array(
            'franchise_id' => $request->franchise_id,
            'name' => $request->name,
            'email' => $request->email,
        );
        $providerArray = $this->providerService->saveProviderList($data);
        echo "Provider saved successfully.";  
    }
    
    public function edit(Request $request): View
    {
        $franchiseList = $this->franchiseService->getCompleteList();
        $id = $request->id;
        $providerShow = $this->providerService->getById($id);
        return view('provider.editprovider',['providershow' => $providerShow,'franchises' => $franchiseList]);        
    }
    public function update(Request $request, $id)
    {
        $providerArray = array(
            'franchise_id' => $request->franchise_id,
            'name' => $request->name,
            'email' => $request->email
        );   
        $this->providerService->update($providerArray, $id);
        echo "Updated provider successfully";         
    }
    public function destroy($id):View
    {
        $this->providerService->delete($id);
        $providerList = $this->providerService->getCompleteList();
        return view('provider.providerlist',['providers' => $providerList]);        
    }
    
    
    
    
    
    
    
    
    
    
}
