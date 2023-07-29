<?php

namespace App\Http\Middleware;

use App\Utils\HttpResponse;
use App\Utils\Roles;
use Closure;
use Illuminate\Contracts\Auth\Factory as Auth;
use Tymon\JWTAuth\Facades\JWTAuth;

class Authenticate
{
    /**
     * The authentication guard factory instance.
     *
     * @var \Illuminate\Contracts\Auth\Factory
     */
    protected $auth;

    /**
     * Create a new middleware instance.
     *
     * @param  \Illuminate\Contracts\Auth\Factory  $auth
     * @return void
     */
    public function __construct(Auth $auth)
    {
        $this->auth = $auth;
    }

    /**
     * Handle an incoming request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \Closure  $next
     * @param  string|null  $guard
     * @return mixed
     */
    public function handle($request, Closure $next, String $roles)
    {
        $validateRoles = Roles::checkExistRole($roles);
        
        if (!$validateRoles) {
            return HttpResponse::error('There is an invalid role in your route', 400);
        }

        if (!$this->checkExistToken($request)) {
            return HttpResponse::error('Token is required', 400);
        }
        $token = explode(' ', $request->header('Authorization'))[1];
        $token = JWTAuth::setToken($token)->getPayload();

        if (!$this->checkRole($validateRoles)) {
            return HttpResponse::error('You do not have permission to access this route', 403);
        }
        return $next($request);
    }

    public function checkRole($roles)
    {
        if (empty(auth()->user()->type)) {
            return false;
        }


        foreach ($roles as $role) {
            if (in_array(auth()->user()->type, [$role])) {
                return true;
            }
        }
    }

    public function checkExistToken($request)
    {
        if ($request->header('Authorization')) {
            return true;
        }
        return false;
    }
}