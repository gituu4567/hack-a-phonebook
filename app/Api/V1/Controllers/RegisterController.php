<?php

namespace App\Api\V1\Controllers;

use App\Http\Controllers\Controller;
use App\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\Hash;
use Symfony\Component\HttpKernel\Exception\HttpException;

/**
 * Class RegisterController
 * @package App\Api\V1\Controllers
 */
class RegisterController extends Controller {

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
			'password' => 'required|string|min:6',
		]);

		if ($validator->fails()){
			return response()->json($validator->errors()->toJson(), 400);
		}

		$user = new User([
			'email' => $request->email,
			'password' => Hash::make($request->get('password')),
		]);

		if (!$user->save()){
			throw new HttpException(500, "Internal server error");
		}

		$token = auth()->login($user);

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
