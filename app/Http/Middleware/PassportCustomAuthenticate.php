<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Auth\Middleware\Authenticate;

class PassportCustomAuthenticate extends Authenticate
{
    protected function unauthenticated($request, array $guards)
    {
        abort(401, 'Unauthorized');
    }
}
