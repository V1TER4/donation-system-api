<?php

namespace Tests\Feature;

use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Tests\TestCase;

use App\Models\FinancialInstitution;

class FavoriteControllerTest extends TestCase
{
    private $token = '';
    private $user_id = '';
    private $email = 'teste@unitario.com';
    private $password = 'senhas123';

    /**
     * A basic feature test example.
     */
    private function login(){
        $loginResponse = $this->postJson('/api/login', [
            'email' => $this->email,
            'password' => $this->password
        ]);
        $loginResponse->assertStatus(200);
        
        $this->token = $loginResponse->json('token');
        $this->user_id = $loginResponse->json('data.id');
    }

    public function test_create_favorite(): void
    {
        $this->login();
        
        $institution = FinancialInstitution::factory()->create();
        $data = [
            'user_id' => $this->user_id,
            'institution_id' => $institution->id
        ];
        $response = $this->postJson('/api/favorite', $data, [
            'Authorization' => "Bearer " . $this->token
        ]);

        $response->assertStatus(201);
    }

    public function test_delete_favorite(): void
    {
        $this->login();
        $response = $this->delete('/api/favorite/' . $this->user_id, [], [
            'Authorization' => "Bearer " . $this->token
        ]);

        $response->assertStatus(200);
    }
}
