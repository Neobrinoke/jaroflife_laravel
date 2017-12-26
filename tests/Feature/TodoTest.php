<?php

namespace Tests\Feature;

use App\Todo;
use App\User;
use Tests\TestCase;
use Illuminate\Foundation\Testing\WithFaker;
use Illuminate\Foundation\Testing\RefreshDatabase;

class TodoTest extends TestCase
{
	public function testIndexAsGuest()
	{
		$response = $this->get(
			route('todo.index')
		);
		$response->assertRedirect(
			route('login')
		);
	}

	public function testIndexAsConnectedUser()
	{
		$response = $this->actingAs(
			new User
		)->get(
			route('todo.index')
		);
		$response->assertSuccessful();
	}
}
