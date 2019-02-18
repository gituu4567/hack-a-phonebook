<?php

namespace Tests\Feature;

use App\User;
use Illuminate\Foundation\Testing\DatabaseMigrations;
use Tests\TestCase;

class AuthenticationTest extends TestCase {
	use DatabaseMigrations;

	public function setUp(){
		parent::setUp();

		$user = new User([
			'email' => 'user@test.com',
			'password' => 'sEcrEt',
		]);

		$user->save();
	}

	public function testRegister(){
		$response = $this->post('api/register', [
			'email' => 'user_new@test.com',
			'password' => 'password',
		]);

		$response->assertJsonStructure([
			'access_token',
			'token_type',
			'expires_in',
		]);
	}

	public function testLogin(){
		$response = $this->post('api/login', [
			'email' => 'user@test.com',
			'password' => 'sEcrEt',
		]);

		$response->assertJsonStructure([
			'access_token',
			'token_type',
			'expires_in',
		]);
	}

	public function testLoginFailsWhenWrongPassword(){
		$response = $this->post('api/login', [
			'email' => 'user@test.com',
			'password' => 'faker',
		]);

		$response->assertJsonStructure([
			'error',
		]);
	}
}
