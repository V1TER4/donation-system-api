<?php

namespace Tests\Feature;

use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

use App\Models\User;

class UserControllerTest extends TestCase
{
    // use RefreshDatabase;

    private $token = '';
    private $name = 'Teste Unitario';
    private $email = 'teste@unitario.com';
    private $password = 'senhas123';

    /**
     * A basic feature test example.
     */
    public function test_register_user(): void {
        $response = $this->postJson('/api/register', [
            'name' => $this->name,
            'email' => $this->email,
            'password' => $this->password,
            'password_confirmation' => $this->password,
        ]);
        $response->assertStatus(201);
    }

    public function test_login():void {
        $loginResponse = $this->postJson('/api/login', [
            'email' => $this->email,
            'password' => $this->password
        ]);

        $loginResponse->assertStatus(200);
    }
}
