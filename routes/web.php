<?php
namespace App\Domains\Login\Http\Controllers;
namespace App\Http\Controllers\Auth;
namespace App\Http\Controllers;


use Illuminate\Support\Facades\Route;
use App\Domains\Login\Http\Controllers\LoginAuthenticationController;
use App\Domains\Login\Http\Controllers\ProviderController;
use App\Http\Controllers\AdminController;
use App\Http\Controllers\Auth\AuthenticatedSessionController;
use Illuminate\Support\Facades\Session;
use App\Domains\Provider\Http\Controllers\ProviderHomeController;
use App\Domains\Provider\Http\Controllers\ProviderUserController;
use App\Http\Middleware\SessionHasAdmin;

/* Route::domain('{subdomain}.localhost')->group(function () {
    Route::get('/', function ($subdomain) {
        return view('welcome', ['subdomain' => $subdomain]);
    });
}); 
 * */

Route::domain('admin.bizzcommerce.localhost')->group(function () {
    Route::get('/', function () {
         return view('auth.login');
    });
});


Route::get('bizzcommerce.localhost', function () {
     return view('errors.404');
}); 

Route::domain('franchise.bizzcommerce.localhost')->group(function () {
    Route::get('/', function () {
         return view('auth.franchisehome');
    });
});
   
/*Route::get('/', function () {
    return view('welcome');
});*/

Route::middleware(['web'])->group(function() {
    require base_path('App\Domains\Login\routes\login.php');
});

Route::post('logout', [AuthenticatedSessionController::class, 'destroy'])->name('logout');

Route::domain('{provider}.bizzcommerce.localhost')->group(function () {
    Route::get('/', [ProviderHomeController::class, 'providerCheck']);
});
