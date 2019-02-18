<?php

namespace Tests\Feature\Feature\Contacts;

use App\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\Feature\Feature\BaseTestCase;
use Tymon\JWTAuth\Facades\JWTAuth;

class ContactCreateTest extends BaseTestCase {
	use RefreshDatabase;

	public function testCreateRequiresToken(){
		$payload = [

		];

		$this->json('post', '/api/contacts/create', $payload)
			->assertStatus(401)
			->assertJson([
				'message' => 'Token not provided',
				'status_code' => 401,
			]);
	}

	public function testCreateSuccess(){
		$user = factory(User::class)->create();

		$token = JWTAuth::fromUser($user);

		$payload = [
			'first_name' => 'John',
			'last_name' => 'Wayne',
			'mobile' => '650-111-1234',
			'token' => $token,
		];

		$this->json('post', '/api/contacts/create', $payload)
			->assertStatus(201)
			->assertJson([
				'first_name' => 'John',
				'last_name' => 'Wayne',
				'mobile' => '650-111-1234',
			]);;
	}
}
