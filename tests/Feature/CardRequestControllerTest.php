<?php

namespace Tests\Feature;

use App\Models\BankAccount;
use App\Models\Card;
use App\Models\CardRequest;
use App\Models\User;
use App\Models\Client;

use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class CardRequestControllerTest extends TestCase
{
    use RefreshDatabase;

    public function test_approve_card_request()
    {
        // Step 1: Create a user and bank account
        $user = Client::factory()->create();
        $bankAccount = BankAccount::factory()->create([
            'client_id' => $user->id,
            'balance' => 1000, // Initial balance
        ]);
    
        // Step 2: Create a card request
        $cardRequest = CardRequest::factory()->create([
            'client_id' => $user->id,
            'bank_account_id' => $bankAccount->id,
            'monthly_salary' => 500,
            'status' => 'pending',
        ]);
    
        // Step 3: Act as the user and call the approve method
        $response = $this->actingAs($user)->post(route('card-requests.approve', $cardRequest->id));
    
        // Step 4: Assert the response
        $response->assertRedirect(route('card-requests.index'))
                 ->assertSessionHas('success', 'Card request approved.');
    
        // Step 5: Assert the card request status is updated
        $this->assertDatabaseHas('card_requests', [
            'id' => $cardRequest->id,
            'status' => 'approved',
        ]);
    
        // Step 6: Assert the bank account balance is updated
        $this->assertDatabaseHas('bank_accounts', [
            'id' => $bankAccount->id,
            'balance' => 1500, // 1000 + 500
        ]);
    
        // Step 7: Assert a new card is created
        $this->assertDatabaseHas('cards', [
            'bank_account_id' => $bankAccount->id,
            'status' => 'approved',
        ]);
    }
   
}