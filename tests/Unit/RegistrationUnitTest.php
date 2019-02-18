<?php
namespace Tests\Unit;

use Tests\TestCase;
use Illuminate\Foundation\Testing\RefreshDatabase;

class RegistrationUnitTest extends TestCase {
	use RefreshDatabase;

	/**
	 * A simple registration test
	 *
	 * @return void
	 */
	public function testRegistrationSuccess(){

		$data = [
			'email' => 'janedoe@email.com',
			'password' => 'password',
		];
		$this->post('/api/auth/register', $data)
			->assertStatus(200);
	}
}
