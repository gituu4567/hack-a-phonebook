<?php

namespace App\Api\V1\Controllers;

use App\Http\Controllers\Controller;

/**
 * Class LoginController
 * @package App\Api\V1\Controllers
 */
class LoginController extends Controller {

	/**
	 * Sign in a new user
	 * Respond with token
	 *
	 * @return \Illuminate\Http\JsonResponse
	 */
	public function login(){
		$credentials = request(['email', 'password']);

		if (!$token = auth()->attempt($credentials)){
			return response()->json(['error' => 'Unauthorized'], 401);
		}

		return $this->tokenResponse($token);
	}

	/**
	 * @param $token
	 * @return \Illuminate\Http\JsonResponse
	 */
	private function tokenResponse($token){
		return response()->json([
			'access_token' => $token,
			'token_type' => 'bearer',
			'expires_in' => auth()->factory()->getTTL() * 60,
		]);
	}
}
