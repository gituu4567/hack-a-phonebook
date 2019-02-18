<?php

namespace Tests\Feature\Feature;

use App\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Support\Facades\Hash;

class LoginTest extends BaseTestCase {
	use RefreshDatabase;

	public function testLoginSuccess(){
		$payload = [
			'email' => 'johndoe@email.com',
			'password' => 'password',
		];

		factory(User::class)->create([
			'email' => $payload['email'],
			'password' => Hash::make($payload['password']),
		]);

		$this->json('post', '/api/auth/login', $payload)
			->assertStatus(200)
			->assertJsonStructure([
				'access_token',
				'token_type',
				'expires_in',
			]);
	}

	public function testLoginFailsValidation(){
		$this->json('post', '/api/auth/login')
			->assertStatus(400)
			->assertJson([
				'email' => ['The email field is required.'],
				'password' => ['The password field is required.'],
			]);
	}

	public function testLoginFailsWhenInvalidUser(){
		$payload = [
			'email' => 'johndoe@email.com',
			'password' => 'password',
		];
		$this->json('post', '/api/auth/login', $payload)
			->assertStatus(401)
			->assertJson([
				'error' => 'Unauthorized',
			]);
	}
}
