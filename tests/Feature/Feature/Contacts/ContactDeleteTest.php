<?php

namespace Tests\Feature\Feature\Contacts;

use App\Contact;
use App\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\Feature\Feature\BaseTestCase;
use Tymon\JWTAuth\Facades\JWTAuth;

class ContactDeleteTest extends BaseTestCase {
	use RefreshDatabase;

	public function testDeleteRequiresToken(){
		$this->json('delete', '/api/contacts/delete/1')
			->assertStatus(401)
			->assertJson([
				'message' => 'Token not provided',
				'status_code' => 401,
			]);
	}

	public function testDeleteSuccess(){
		$user = factory(User::class)->create();
		$token = JWTAuth::fromUser($user);

		$payload = [
			'first_name' => 'John',
			'last_name' => 'Wayne',
			'mobile' => '650-111-1234',
			'user_id' => $user->id,
		];

		$contact = factory(Contact::class)->create($payload);

		$this->json('delete', '/api/contacts/delete/' . $contact->id . '?token=' . $token)
			->assertStatus(204);

		$this->assertDatabaseMissing('contacts', [
			'id' => $contact->id
		]);

	}

	/**
	 * We check that the user can not delete a phonebook entry that they dont own
	 */
	public function testDeleteAccessErrors(){
		$user = factory(User::class)->create();
		$token = JWTAuth::fromUser($user);

		$payload = [
			'first_name' => 'John',
			'last_name' => 'Wayne',
			'mobile' => '650-111-1234',
			'user_id' => $user->id+100 // resource owned by a different user
		];

		$contact = factory(Contact::class)->create($payload);

		$this->json('delete', '/api/contacts/delete/' . $contact->id . '?token=' . $token)
			->assertStatus(403)
			->assertJson([
				'message' => 'Access denied',
			]);

		$this->assertDatabaseHas('contacts', [
			'id' => $contact->id
		]);
	}
}
