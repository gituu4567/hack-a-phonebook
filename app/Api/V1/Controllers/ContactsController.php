<?php

namespace App\Api\V1\Controllers;

use App\Contact;
use Illuminate\Http\JsonResponse;
use Illuminate\Support\Facades\Validator;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Symfony\Component\HttpKernel\Exception\AccessDeniedHttpException;
use Symfony\Component\HttpKernel\Exception\HttpException;
use Tymon\JWTAuth\Facades\JWTAuth;
use Illuminate\Support\Facades\DB;


/**
 * Class ContactsController
 * @package App\Api\V1\Controllers
 */
class ContactsController extends Controller {

	/**
	 * @param Request $request
	 * @return JsonResponse
	 */
	public function create(Request $request){
		$current_user = JWTAuth::parseToken()->authenticate();

		$validator = Validator::make($request->all(), [
			'first_name' => 'required|string|max:128',
			'last_name' => 'required|string|max:128',
			'mobile' => 'required|string|max:15',
		]);

		if ($validator->fails()){
			return response()->json($validator->errors()->toJson(), 400);
		}

		$contact = new Contact([
			'first_name' => $request->first_name,
			'last_name' => $request->last_name,
			'mobile' => $request->mobile,
			'user_id' => $current_user->id,
		]);

		if (!$contact->save()){
			throw new HttpException(500, "Internal server error");
		}

		return response()->json($contact, 201);
	}

	/**
	 * @return JsonResponse
	 */
	public function getAll(){
		$current_user = JWTAuth::parseToken()->authenticate();
		$contacts = DB::table('contacts')->where('user_id', $current_user->id)->orderBy('updated_at', 'desc')->get();

		return response()->json($contacts, 200);
	}

	/**
	 * @param Contact $contact
	 * @return JsonResponse
	 */
	public function get(Contact $contact){
		$current_user = JWTAuth::parseToken()->authenticate();

		if ($contact->user_id==$current_user->id){
			return response()->json($contact, 200);
		}

		throw new AccessDeniedHttpException('Access denied');
	}

	/**
	 * @param Request $request
	 * @param Contact $contact
	 * @return JsonResponse
	 */
	public function update(Request $request, Contact $contact){
		$current_user = JWTAuth::parseToken()->authenticate();
		if ($contact->user_id!=$current_user->id){
			throw new AccessDeniedHttpException('Access denied');
		}

		$validator = Validator::make($request->all(), [
			'first_name' => 'string|max:128',
			'last_name' => 'string|max:128',
			'mobile' => 'numeric|max:15',
		]);

		if ($validator->fails()){
			return response()->json($validator->errors()->toJson(), 400);
		}

		$contact->update($request->all());

		return response()->json($contact, 200);
	}

	/**
	 * @param Contact $contact
	 * @return JsonResponse
	 */
	public function delete(Contact $contact){
		$current_user = JWTAuth::parseToken()->authenticate();
		if ($contact->user_id!=$current_user->id){
			throw new AccessDeniedHttpException('Access denied');
		}

		$contact->delete();

		return response()->json(null, 204);
	}

}
