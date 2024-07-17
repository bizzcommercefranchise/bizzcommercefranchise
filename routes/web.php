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

/* Route::domain('{subdomain}.localhost')->group(function () {
    Route::get('/', function ($subdomain) {
        return view('welcome', ['subdomain' => $subdomain]);
    });
}); 
    Route::domain('admin.bizzcommerce.localhost')->group(function () {
        Route::get('/', function () {
             return view('admin.admin_dashboard');
        });
    }
 * */
 
//Route::middleware(['auth','role:admin'])->group(function(){
    Route::domain('admin.bizzcommerce.localhost')->group(function () {
        Route::get('/', function () {
             return view('auth.login');
         });
    });
//}

Route::domain('franchise.bizzcommerce.localhost')->group(function () {
    Route::get('/', function () {
         return view('auth.franchisehome');
    });
});

/*
Route::get('/', function () {
    return view('auth.login');
});*/
         
/*Route::get('/', function () {
    return view('welcome');
});*/

Route::middleware(['web'])->group(function() {
    require base_path('App\Domains\Login\routes\login.php');
});

Route::post('logout', [AuthenticatedSessionController::class, 'destroy'])
                ->name('logout');

//Route::get('franchise/register', 'FranchiseController@create1')->name('franchiseRegister');
//                    Route::get('/admin/generate-url', [AdminController::class, 'generateUrl'])->name('admin.generateUrl');
//Route::get('/franchise/franchiseGetById/{company}', AdminController::class .'@franchiseUrl')->name('admin.franchiseById'); 
//Route::get('/franchise/franchise-show/{franchiseName}', [CustomerController::class, 'showFranchise']);

//Route::get('franchise/register', [FranchiseController::class, 'create1'])
//                ->name('franchiseRegister');

//Route::get('/providers/homeEdit/{id}', ProviderHomeController::class . '@edit')->name('provider.homeEdit');
//Route::get('/providers/{provider}', ProviderHomeController::class . '@providerCheck');

Route::domain('{provider}.bizzcommerce.localhost')->group(function () {
    Route::get('/', [ProviderHomeController::class, 'providerCheck']);
});

/* Route::domain('{providerlocation}.bizzcommerce.localhost')->group(function () {
    Route::get('/', [ProviderHomeController::class, 'providerLocationCheck']);
});*/
