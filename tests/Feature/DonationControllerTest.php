<?php

namespace Tests\Feature;

use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

use App\Models\Donation;
use App\Models\FinancialInstitution;

class DonationControllerTest extends TestCase
{
    // use RefreshDatabase;

    private $token = '';
    private $user_id = '';
    private $email = 'teste@unitario.com';
    private $password = 'senhas123';

    private function login(){
        $loginResponse = $this->postJson('/api/login', [
            'email' => $this->email,
            'password' => $this->password
        ]);
        $loginResponse->assertStatus(200);
        
        $this->token = $loginResponse->json('token');
        $this->user_id = $loginResponse->json('data.id');
    }

    public function test_make_donation(): void{
        $this->login();

        $institution = FinancialInstitution::factory()->create();
        $donation = [
            'institution_id' => $institution->id,
            'user_id' => $this->user_id,
            'value' => 10
        ];
        $response = $this->postJson('/api/donation', $donation, [
            'Authorization' => "Bearer " . $this->token
        ]);
        $response->assertStatus(201);

        $this->assertDatabaseHas('donations', [
            'user_id' => $this->user_id,
            'institution_id' => $institution->id,
            'value' => 10
        ]);
    }

    public function test_consult_user_history():void {
        $this->login();

        $response = $this->withHeaders([
            'Authorization' => "Bearer {$this->token}"
        ])->getJson('/api/donation/' . $this->user_id);

        \Log::info(json_encode($response));

        $response->assertStatus(200);
    }
}
