<?php

namespace App\Domains\Login\Http\Controllers;
namespace App\Http\Controllers\Auth;
namespace App\Domains\Franchise\Http\Controllers;
namespace App\Http\Controllers;
namespace App\Domains\Provider\Http\Controllers;

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Auth\AuthenticatedSessionController;
use App\Http\Controllers\Auth\ProviderController;
use App\Http\Controllers\Auth\ConfirmablePasswordController;
use App\Http\Controllers\Auth\EmailVerificationNotificationController;
use App\Http\Controllers\Auth\EmailVerificationPromptController;
use App\Http\Controllers\Auth\NewPasswordController;
use App\Http\Controllers\Auth\PasswordController;
use App\Http\Controllers\Auth\PasswordResetLinkController;
use App\Http\Controllers\Auth\RegisteredUserController;
use App\Http\Controllers\Auth\VerifyEmailController;
use App\Http\Controllers\FranchiseController;
use App\Http\Controllers\UserController;
use App\Domains\Franchise\Http\Controllers\FranchiseHomeController;
use App\Domains\Provider\Http\Controllers\ProviderHomeController;
use App\Domains\Login\Http\Controllers\EndUserController;

Route::get('/franchise/login', FranchiseHomeController::class . '@index')->name('auth.franchisehome');
Route::post('/franchise/homeLogin', [FranchiseHomeController::class, 'store'])->name('franchisehome.login.post');
Route::get('/franchise/homeRegister', [FranchiseHomeController::class, 'create'])->name('franchise.home.register');
Route::post('/franchise/homeStore', FranchiseHomeController::class .'@franchiseHomeStore')->name('franchisehome.store');

Route::get('/providers/list', ProviderController::class . '@show')->name('providersList');
Route::get('/providers/register', ProviderController::class .'@create')->name('provider.register');
Route::post('/providers/store', ProviderController::class .'@providerStore')->name('provider.store'); 
Route::post('/locations/store', ProviderHomeController::class .'@locationStore')->name('location.store'); 
Route::get('/providers/edit/{id}', ProviderController::class . '@edit')->name('provider.edit');
Route::post('/providers/update/{id}',ProviderController::class . '@update')->name('provider.update');
Route::get('/providers/delete/{id}', ProviderController::class . '@destroy')->name('provider.delete');

Route::get('/users/list', UserController::class . '@show')->name('usersList');
Route::get('/providerusers/list', UserController::class . '@providerUserShow')->name('providerUsersList');
Route::get('/users/register', UserController::class .'@create')->name('user.register');
Route::get('/homeProvider/userRegister', UserController::class .'@providerUserCreate')->name('homeProviderUser.register');
Route::get('/users/edit/{id}', UserController::class . '@edit')->name('user.edit');
Route::get('/providerUsers/edit/{id}', UserController::class . '@providerUseredit')->name('homeProiverUser.edit');
Route::get('/users/delete/{id}', UserController::class . '@destroy')->name('user.delete');
Route::get('/providerUsers/delete/{id}', UserController::class . '@providerDestroy')->name('homeProiverUser.delete');
Route::post('/users/update/{id}', UserController::class . '@update')->name('user.update');
Route::post('/homeProviderUsers/update/{id}', UserController::class . '@providerUserUpdate')->name('homeProviderUser.update');
Route::post('/users/store', UserController::class .'@store')->name('user.store'); 
Route::post('/homeProvider/usersStore', UserController::class .'@providerUserStore')->name('homeProivderUser.store'); 

Route::post('/franchises/update/{id}', FranchiseController::class . '@update')->name('franchise.update');
Route::get('/franchises/edit/{id}', FranchiseController::class . '@edit')->name('franchise.edit');
Route::get('/franchises/delete/{id}', FranchiseController::class . '@destroy')->name('franchise.delete');
Route::get('/franchises/list', FranchiseController::class . '@show')->name('franchisesList');
Route::get('/franchise/register', FranchiseController::class .'@create')->name('franchise.register'); 
Route::post('/franchise/store', FranchiseController::class .'@store')->name('franchise.store');

Route::middleware('guest')->group(function () {
    Route::get('register', [RegisteredUserController::class, 'create'])
                ->name('register');

//    Route::get('franchise-register', FranchiseController::class .'@create')->name('franchiseRegister'); 
      
    Route::post('register', [RegisteredUserController::class, 'store']);

    Route::get('login', [AuthenticatedSessionController::class, 'create'])
                ->name('login');
    
    Route::post('login', [AuthenticatedSessionController::class, 'store']);

    Route::get('forgot-password', [PasswordResetLinkController::class, 'create'])
                ->name('password.request');

    Route::post('forgot-password', [PasswordResetLinkController::class, 'store'])
                ->name('password.email');

    Route::get('reset-password/{token}', [NewPasswordController::class, 'create'])
                ->name('password.reset');

    Route::post('reset-password', [NewPasswordController::class, 'store'])
                ->name('password.store');
    
    Route::get('login/provider', [ProviderController::class, 'showLoginForm'])
                ->name('provider.login');
    
    Route::post('login', [ProviderController::class, 'store'])->name('provider.login.post');
  
});

Route::middleware('auth')->group(function () {
    Route::get('verify-email', EmailVerificationPromptController::class)
                ->name('verification.notice');

    Route::get('verify-email/{id}/{hash}', VerifyEmailController::class)
                ->middleware(['signed', 'throttle:6,1'])
                ->name('verification.verify');

    Route::post('email/verification-notification', [EmailVerificationNotificationController::class, 'store'])
                ->middleware('throttle:6,1')
                ->name('verification.send');

    Route::get('confirm-password', [ConfirmablePasswordController::class, 'show'])
                ->name('password.confirm');

    Route::post('confirm-password', [ConfirmablePasswordController::class, 'store']);

    Route::put('password', [PasswordController::class, 'update'])->name('password.update');

    Route::post('logout', [AuthenticatedSessionController::class, 'destroy'])
                ->name('logout');
     
});

/*
Route::get('/dashboard', function () {
     return view('dashboard');
}); */

Route::get('/admin/dashboard', [ProviderController::class, 'showProducts']);
Route::get('/provider/dashboard', [ProviderController::class, 'showProducts']);
Route::get('/user/dashboard', [UserController::class, 'index'])->name('user.dashboard');
Route::get('/franchise/dashboard', [FranchiseHomeController::class, 'dashboard']);

//Route::get('franchise/register', 'FranchiseController@create1')->name('franchiseRegister');
//Route::get('franchise/register', [FranchiseController::class, 'create1'])
//                ->name('franchiseRegister');
//Route::post('login', [AdminController::class, 'store'])->name('admin.login.post');
Route::get('/home/providers/list', ProviderHomeController::class . '@show')->name('homeProvidersList');
Route::get('/home/locations', ProviderHomeController::class . '@showLocations')->name('homeLocationsList');
Route::get('/providers/homeRegister', ProviderHomeController::class .'@create')->name('provider.homeRegister');
Route::get('/providers/locationRegister', ProviderHomeController::class .'@createLocation')->name('provider.locationRegister');
Route::post('/providers/homeStore', ProviderHomeController::class .'@providerStore')->name('provider.homeStore'); 
Route::get('/providers/homeEdit/{id}', ProviderHomeController::class . '@edit')->name('provider.homeEdit');
Route::get('/providers/locationEdit/{id}', ProviderHomeController::class . '@editLocation')->name('provider.locationEdit');
Route::post('/providers/homeUpdate/{id}',ProviderHomeController::class . '@update')->name('provider.homeUpdate');
Route::post('/locationUpdate/{id}',ProviderHomeController::class . '@updateLocation')->name('provider.locationUpdate');
Route::get('/providers/homeDelete/{id}', ProviderHomeController::class . '@destroy')->name('provider.homeDelete');
Route::get('/providers/locationDelete/{id}', ProviderHomeController::class . '@destroyLocation')->name('provider.locationDelete');
Route::get('login/providerHome', [ProviderHomeController::class, 'providerLogin'])
                ->name('home.provider.loginHome');
Route::post('providerHome/login', [ProviderHomeController::class, 'providerHomeStore'])->name('providerHome.login.post');
Route::get('/providerHome/dashboard', [ProviderHomeController::class, 'providerHome']);

Route::post('userHome/login', [ProviderHomeController::class, 'userHomeStore'])->name('userHome.login.post');
Route::post('homeEndUser/store', EndUserController::class .'@store')->name('homeEndUser.store');
Route::get('homeEndUser/register', EndUserController::class .'@create')->name('homeEndUser.register');
Route::post('enduserHome/login', [EndUserController::class, 'endUserHomeStore'])->name('enduserHome.login.post');
Route::get('/enduserProductHome/dashboard', [EndUserController::class, 'enduserHome']);
Route::get('/enduserHome', [EndUserController::class, 'enduserHomeProducts']);
Route::get('/enduserHome/dashboard', [EndUserController::class, 'enduserHome']);
Route::get('/enduserProductHome/login', [EndUserController::class, 'enduserHomeLogin'])->name('home.enduser.loginHome');
Route::get('/enduserHome/profileEdit/{id}', [EndUserController::class, 'profileEdit'])->name('profile.edit');
Route::get('/homeEndUser/update/{id}', [EndUserController::class, 'endUserUpdate'])->name('homeEndUser.update');
 Route::get('/home/providerProductList', ProviderHomeController::class . '@productShow')->name('providerProductsList');
 Route::get('/home/providerAddProduct', ProviderHomeController::class . '@createProduct')->name('provider.homeProductAdd');
Route::post('/home/providerProductStore', ProviderHomeController::class .'@providerProductStore')->name('provider.homeProductStore'); 
Route::get('/home/providerProductEdit/{id}', ProviderHomeController::class . '@editProduct')->name('provider.homeProductEdit');
Route::post('/providers/homeProductUpdate/{id}',ProviderHomeController::class.'@productupdate')->name('provider.homeProductUpdate');
Route::get('home/providerProductDelete/{id}', ProviderHomeController::class . '@destroyProduct')->name('provider.homeProductDelete');







