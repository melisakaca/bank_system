<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\CardRequest;
use App\Models\Card;
use Illuminate\Support\Facades\Auth;

class CardController extends Controller
{
    public function create()
    {
        $bankAccounts = auth()->user()->bankAccounts()->where('status', 'approved')->get();
        return view('backend.client.request_card', compact('bankAccounts'));
    }

    // Store a new card request (for clients)
    public function store(Request $request)
    {
        $request->validate([
            'bank_account_id' => 'required|exists:bank_accounts,id',
            'monthly_salary' => 'required|numeric|min:0',
        ]);

        // Automatically deny if monthly salary is less than €500
        $status = ($request->monthly_salary < 500) ? 'disapproved' : 'pending';

        CardRequest::create([
            'client_id' => auth()->id(),
            'bank_account_id' => $request->bank_account_id,
            'monthly_salary' => $request->monthly_salary,
            'status' => $status,
        ]);

        return redirect()->route('dashboard')->with('success', 'Card request submitted successfully.');
    }

    // List pending card requests (for bankers)
    public function index()
    {
        $cardRequests = CardRequest::where('status', 'pending')->with(['client', 'bankAccount'])->get();
        return view('backend.banker.card_requests', compact('cardRequests'));
    }
    public function indexAll()
    {
        $cardsQuery = Card::with('bankAccount.client');

        if (Auth::user()->can('view_own_cards')) {
            $cardsQuery->whereHas('bankAccount', function ($query) {
                $query->where('client_id', Auth::id());
            });
        }
    
        $cards = $cardsQuery->get();
      
        return view('backend.banker.cardAll', compact('cards'));
    }
    // Approve a card request (for bankers)
    public function approve($id)
    {
        $cardRequest = CardRequest::findOrFail($id);
        $cardRequest->update(['status' => 'approved']);

        // Create a new debit card
        $card = $cardRequest->bankAccount->cards()->create([
            'card_number' => '4' . rand(100000000000000, 999999999999999), 
            'expiry_date' => now()->addYears(3)->format('Y-m-d'),
            'cvv' => rand(100, 999),
            'status' => 'active',
        ]);

        return redirect()->route('card-requests.index')->with('success', 'Card request approved.');
    }

    // Disapprove a card request (for bankers)
    public function disapprove($id, Request $request)
    {
        $request->validate([
            'reason' => 'required|string|max:255',
        ]);

        $cardRequest = CardRequest::findOrFail($id);
        $cardRequest->update([
            'status' => 'disapproved',
            'reason' => $request->reason,
        ]);

        return redirect()->route('card-requests.index')->with('success', 'Card request disapproved.');
    }
}
