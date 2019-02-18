<?php

namespace App\Http\Middleware;

use Closure;
use Exception;
use Illuminate\Http\Request;
use Tymon\JWTAuth\Exceptions\TokenExpiredException;
use Tymon\JWTAuth\Exceptions\TokenInvalidException;
use Tymon\JWTAuth\Http\Middleware\BaseMiddleware;
use Tymon\JWTAuth\JWTAuth;

/**
 * Class JwtMiddleware
 * @package App\Http\Middleware
 */
class JwtMiddleware extends BaseMiddleware {

	/**
	 * Intercepts and handles an incoming request and applies jwt guard.
	 *
	 * @param  Request $request
	 * @param  Closure $next
	 * @return mixed
	 */
	public function handle($request, Closure $next){
		try {
			$user = JWTAuth::parseToken()->authenticate();
		}
		catch (TokenInvalidException $tokenInvalidException) {
			return response()->json(['status' => 'Token is Invalid']);
		}
		catch (TokenExpiredException $tokenExpiredException) {
			return response()->json(['status' => 'Token is Expired']);
		}
		catch (Exception $e) {
			return response()->json(['status' => 'Token not found']);
		}

		return $next($request);
	}
}
