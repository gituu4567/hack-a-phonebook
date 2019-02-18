<?php

namespace App\Http\Controllers;

use App\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\Hash;

/**
 * Class AuthController
 * @package App\Http\Controllers
 */
class ApiAuthController extends Controller {

	/**
	 * Signup a new user
	 * Respond with token
	 *
	 * @param Request $request
	 * @return \Illuminate\Http\JsonResponse
	 */
	public function register(Request $request){
		$validator = Validator::make($request->all(), [
			'email' => 'required|string|email|max:255|unique:users',
			'password' => 'required|string|min:6|confirmed',
		]);

		if ($validator->fails()){
			return response()->json($validator->errors()->toJson(), 400);
		}

		$user = User::create([
			'email' => $request->email,
			'password' => Hash::make($request->get('password')),
		]);

		$token = auth()->login($user);

		return $this->tokenResponse($token);
	}

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
	protected function tokenResponse($token){
		return response()->json([
			'access_token' => $token,
			'token_type' => 'bearer',
			'expires_in' => auth()->factory()->getTTL() * 60,
		]);
	}
}
