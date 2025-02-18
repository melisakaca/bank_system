<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\BankAccount;
use Illuminate\Support\Facades\Auth;

class BankAccountController extends Controller
{

    public function __construct()
    {  
        $this->middleware(['permission:request_bank_account'])->only( 'create', 'store');
        // $this->middleware(['permission:view_own_account'])->only( 'edit', 'destroy');

       
    }
    public function create()
    {
        return view('backend.client.request_account');
    }

    // Store a new bank account request (for clients)
    public function store(Request $request)
    {
        $request->validate([
            'currency' => 'required|string|in:EUR',
        ]);

        // Generate a unique IBAN
        $iban = 'GB' . rand(10000000, 99999999);

        // Create the bank account request
        BankAccount::create([
            'iban' => $iban,
            'currency' => $request->currency,
            'balance' => 0.00,
            'status' => 'pending',
            'client_id' => auth()->id(),
        ]);

        return redirect()->route('dashboard')->with('success', 'Bank account request submitted successfully.');
    }

    // List pending requests (for bankers)
    public function index()
    {
        $pendingRequests = BankAccount::where('status', 'pending')->with('client')->get();
        return view('backend.banker.pending_requests', compact('pendingRequests'));
    }

    public function indexBankAccounts()
    {
      
        $bankAccountQuery = BankAccount::with('client');

        if (Auth::user()->can('view_own_accounts')) {
            $bankAccountQuery->where('client_id', Auth::id());
        }
    
        $bankAccounts = $bankAccountQuery->get();
        return view('backend.banker.bankAccounts', compact('bankAccounts'));
    }
    // Approve a bank account request (for bankers)
    public function approve($id)
    {
        $bankAccount = BankAccount::findOrFail($id);
        $bankAccount->update(['status' => 'approved']);

        return redirect()->route('bank-accounts.index')->with('success', 'Bank account request approved.');
    }

    // Disapprove a bank account request (for bankers)
    public function disapprove($id)
    {
        $bankAccount = BankAccount::findOrFail($id);
        $bankAccount->update(['status' => 'disapproved']);

        return redirect()->route('bank-accounts.index')->with('success', 'Bank account request disapproved.');
    }
}
