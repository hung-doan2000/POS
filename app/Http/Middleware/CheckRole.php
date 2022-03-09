<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Exceptions\HttpResponseException;
use Illuminate\Http\Request;

class CheckRole
{
    /**
     * Handle an incoming request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \Closure  $next
     * @return mixed
     */
    public function handle(Request $request, Closure $next, $role)
    {
        if (! $request->user()->hasRole($role))
        {
            if ('application/json' == $request->header('Content-Type'))
            {
                $response = ['error' => 'This action is access denied!'];

                throw new HttpResponseException(response()->json($response, 403));
            }

            abort(403, 'This action is access denied!');
        }

        return $next($request);
    }

}
