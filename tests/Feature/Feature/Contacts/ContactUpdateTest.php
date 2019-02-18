<?php

namespace Tests\Feature\Feature\Contacts;

use App\Contact;
use App\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\Feature\Feature\BaseTestCase;
use Tymon\JWTAuth\Facades\JWTAuth;

class ContactUpdateTest extends BaseTestCase {
	use RefreshDatabase;

	public function testUpdateRequiresToken(){
		$this->json('post', '/api/contacts/update/1')
			->assertStatus(401)
			->assertJson([
				'message' => 'Token not provided',
				'status_code' => 401,
			]);
	}

	public function testUpdateSuccess(){
		$user = factory(User::class)->create();
		$token = JWTAuth::fromUser($user);

		$payload = [
			'first_name' => 'John',
			'last_name' => 'Wayne',
			'mobile' => '650-111-1234',
			'user_id' => $user->id,
		];

		$contact = factory(Contact::class)->create($payload);

		$new = [
			'first_name' => 'J W',
			'last_name' => 'Waynard',
			'mobile' => '123-111-1234',
		];
		$new_payload = array_merge($new, ['token' => $token]);

		$this->json('post', '/api/contacts/update/' . $contact->id, $new_payload)
			->assertStatus(200)
			->assertJson($new);
	}

	/**
	 * We check that the user can not access a phonebook entry that they dont own
	 */
	public function testUpdateAccessErrors(){
		$user = factory(User::class)->create();
		$token = JWTAuth::fromUser($user);

		$payload = [
			'first_name' => 'John',
			'last_name' => 'Wayne',
			'mobile' => '650-111-1234',
			'user_id' => $user->id+100 // resource owned by a different user
		];

		$contact = factory(Contact::class)->create($payload);

		$this->json('post', '/api/contacts/update/' . $contact->id . '?token=' . $token)
			->assertStatus(403)
			->assertJson([
				'message' => 'Access denied',
			]);;
	}
}
