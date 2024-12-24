<?php

namespace Tests\Feature;

use Tests\TestCase;
use Illuminate\Foundation\Testing\RefreshDatabase;

class LoginTest extends TestCase
{
    use RefreshDatabase;

    protected function setUp(): void
    {
        parent::setUp();
        // Add any necessary setup
    }

    public function testLoginPost()
    {
        $response = $this->call('POST', '/login', [
            'telephone' => '0782179022',
            'password' => 'badPass',
            '_token' => csrf_token()
        ]);

        $this->assertEquals(200, $response->getStatusCode());
        $this->assertEquals('auth.login', $response->original->name());
    }

    public function testLoginValidation()
    {
        $response = $this->post('/login', []);

        $response->assertStatus(302);
        $response->assertSessionHasErrors(['telephone', 'password']);
    }

    public function testSuccessfulLogin()
    {
        $user = \App\Models\User::factory()->create([
            'telephone' => '0782179022',
            'password' => bcrypt('correctPass')
        ]);

        $response = $this->post('/login', [
            'telephone' => '0782179022',
            'password' => 'correctPass',
            '_token' => csrf_token()
        ]);

        $response->assertStatus(302);
        $this->assertAuthenticatedAs($user);
    }
}
