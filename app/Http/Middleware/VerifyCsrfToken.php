<?php

namespace App\Http\Middleware;

use Illuminate\Foundation\Http\Middleware\VerifyCsrfToken as Middleware;

class VerifyCsrfToken extends Middleware
{
    /**
     * The URIs that should be excluded from CSRF verification.
     *
     * @var array<int, string>
     */
    protected $addHttpCookie = true;
    protected $except = [
        //This is the url that I dont want Csrf for postman.
        'api/api/store',
        'api/api/update/*',
        'api/product/store',
        'api/product/update/*',
        'api/guest/register',
        'api/guest/login/'
    ];
}
