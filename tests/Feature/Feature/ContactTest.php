<?php

namespace Tests\Feature\Feature;

use Illuminate\Foundation\Testing\RefreshDatabase;

class ContactTest extends BaseTestCase {
	use RefreshDatabase;

	public function testCreateSuccess(){
		$payload = [
			'first_name' => 'John',
			'last_name' => 'Wayne',
		];

		$this->json('post', '/api/contacts/create', $payload)
			->assertStatus(200)
			->assertJsonStructure([
				'data' => [
					'access_token',
					'token_type',
					'expires_in',
				],
			]);;
	}
}
