<?php
namespace App\Domains\Login\Http\Controllers;
namespace App\Http\Controllers\Auth;
namespace App\Http\Controllers;
namespace App\Domains\Provider\Http\Controllers;

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

class ProviderUserController extends Controller
{
    
    public function create()
    {
        return view('home.user.register');       
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
    }
}
            