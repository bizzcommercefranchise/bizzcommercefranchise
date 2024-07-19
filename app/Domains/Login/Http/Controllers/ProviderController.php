<?php

namespace App\Http\Controllers\Auth;
namespace App\Domains\Login\Http\Controllers;

use App\Http\Controllers\Controller;
use App\Http\Requests\Auth\LoginRequest;
use App\Providers\RouteServiceProvider;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\View\View;

use App\Models\User;
use Illuminate\Support\Facades\Hash;

use App\Domains\Login\Models\Usercredentials;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Session;

class ProviderController extends Controller
{
    /**
     * Display the login view.
     */
    public function showLoginForm(): View
    {
        return view('auth.provider-login');
    }  
}
