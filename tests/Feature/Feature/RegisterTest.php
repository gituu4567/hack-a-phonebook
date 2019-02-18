<?php

namespace Tests\Feature\Feature;
use Illuminate\Foundation\Testing\RefreshDatabase;

class RegisterTest extends BaseTestCase {
	use RefreshDatabase;

	public function testRegisterSuccess(){
		$payload = [
			'email' => 'newuser123@email.com',
			'password' => 'password',
		];

		$this->json('post', '/api/auth/register', $payload)
			->assertStatus(200)
			->assertJsonStructure([
				'access_token',
				'token_type',
				'expires_in',
			]);;
	}

	public function testRegisterFailsValidation(){
		$this->json('post', '/api/auth/register')
			->assertStatus(400)
			->assertJson([
				'email' => ['The email field is required.'],
				'password' => ['The password field is required.'],
			]);
	}
}
