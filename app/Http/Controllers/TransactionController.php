<?php

namespace App\Http\Controllers;

use App\Models\BankAccount;
use App\Models\Transaction;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;

class TransactionController extends Controller
{

    public function __construct()
    {
        $this->middleware(['permission:perform_transactions'])->only('create', 'store');
        $this->middleware(['permission:view_own_transactions'])->only('index', 'store');

        // //   '',
        //             'perform_transactions'

    }
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
            'destination_iban' => 'required|exists:bank_accounts,iban',
            'amount' => 'required|numeric|min:0.01',
        ]);

        // Retrieve the source and destination accounts
        $sourceAccount = BankAccount::findOrFail($request->source_account);
        $destinationAccount = BankAccount::where('iban', $request->destination_iban)->firstOrFail();

        // Check if the source account has enough balance
        if ($sourceAccount->balance < $request->amount) {
            return redirect()->back()->withErrors(['error' => 'Insufficient balance in the source account.']);
        }

        // Check if the source account is linked to a debit card
        if (!$sourceAccount->cards()->exists()) {
            return redirect()->back()->with('error', 'The source account is not linked to a debit card.');
        }

        if (!$destinationAccount) {
            return redirect()->back()->with('error', 'Destination account not found.');
        }
        // Perform the transaction within a database transaction
        DB::transaction(function () use ($sourceAccount, $destinationAccount, $request) {

            // Create a DEBIT transaction for the source account
            $sourceTransaction = Transaction::create([
                'bank_account_id' => $sourceAccount->id,
                'amount' => $request->amount,
                'currency' => 'EUR',
                'type' => 'DEBIT',
                'related_account'=>$destinationAccount->id,
            ]);


            if (!$sourceTransaction) {
                throw new \Exception('Failed to create source transaction.');
            } else {
                $sourceAccount->decrement('balance', $request->amount);
            }

            // Create a CREDIT transaction for the destination account
            $destinationTransaction = Transaction::create([
                'bank_account_id' => $destinationAccount->id,
                'amount' => $request->amount,
                'currency' => 'EUR',
                'type' => 'CREDIT',
                'related_account'=>$sourceAccount->id
            ]);
            if (!$destinationTransaction) {
                throw new \Exception('Failed to create destination transaction.');
            } else {
                $destinationAccount->increment('balance', $request->amount);
            }
        });

        return redirect()->route('transactions.index')->with('success', 'Transaction completed successfully.');
    }
    // List all transactions (for bankers)
    public function index()
    {
        $transactionsQuery = Transaction::with('bankAccount.client');

        // If the authenticated user can only view their own transactions,
        // filter the transactions based on the bank account's client_id.
        if (Auth::user()->can('view_own_transactions')) {
            $transactionsQuery->whereHas('bankAccount', function ($query) {
                $query->where('client_id', Auth::id());
            });
        }
    
        // Retrieve the filtered transactions
        $transactions = $transactionsQuery->get();
        return view('backend.banker.transactions', compact('transactions'));
    }
}
