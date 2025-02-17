<?php

namespace App\Http\Controllers;

use App\Models\BankAccount;
use App\Models\Transaction;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
class TransactionController extends Controller
{
    public function create()
    {
        $bankAccounts = auth()->user()->bankAccounts()->where('status', 'approved')->get();
        return view('backend.client.perform_transaction', compact('bankAccounts'));
    }

    // Store a new transaction (for clients)
    public function store(Request $request)
    {
        $request->validate([
            'source_account' => 'required|exists:bank_accounts,id',
            'destination_iban' => 'required|string|max:34',
            'amount' => 'required|numeric|min:0.01',
        ]);

        // Find the source account
        $sourceAccount = BankAccount::findOrFail($request->source_account);

        // Validate the source account
        if ($sourceAccount->balance < $request->amount) {
            return redirect()->back()->with('error', 'Insufficient balance in the source account.');
        }

        if (!$sourceAccount->cards()->exists()) {
            return redirect()->back()->with('error', 'The source account is not linked to a debit card.');
        }

        // Find the destination account
        $destinationAccount = BankAccount::where('iban', $request->destination_iban)->first();

        if (!$destinationAccount) {
            return redirect()->back()->with('error', 'Destination account not found.');
        }

        // Perform the transaction
        DB::transaction(function () use ($sourceAccount, $destinationAccount, $request) {
            // Debit the source account
            $sourceAccount->decrement('balance', $request->amount);
            Transaction::create([
                'bank_account_id' => $sourceAccount->id,
                'amount' => $request->amount,
                'currency' => 'EUR',
                'type' => 'debit',
                'related_account' => $destinationAccount->iban,
            ]);

            // Credit the destination account
            $destinationAccount->increment('balance', $request->amount);
            Transaction::create([
                'bank_account_id' => $destinationAccount->id,
                'amount' => $request->amount,
                'currency' => 'EUR',
                'type' => 'credit',
                'related_account' => $sourceAccount->iban,
            ]);
        });

        return redirect()->route('dashboard')->with('success', 'Transaction completed successfully.');
    }

    // List all transactions (for bankers)
    public function index()
    {
        $transactions = Transaction::with('bankAccount.client')->get();
        return view('backend.banker.transactions', compact('transactions'));
    }
}
