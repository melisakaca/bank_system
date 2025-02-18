<?php

namespace App\Http\Controllers;

use App\Models\BankAccount;
use App\Models\Transaction;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Validator;
use Illuminate\Validation\ValidationException;
class TransactionController extends Controller
{

    public function __construct()
    {
        $this->middleware(['permission:perform_transactions'])->only('create');
        // $this->middleware(['permission:view_own_transactions'])->only('index', 'store');
        // $this->middleware(['permission:view_all_transactions'])->only('index', 'store');

    }
    public function create()
    {
        $bankAccounts = auth()->user()->bankAccounts()->where('status', 'approved')->get();
        return view('backend.client.perform_transaction', compact('bankAccounts'));
    }

    // Store a new transaction (for clients)

    public function store(Request $request)
    {
       
        $validator = Validator::make($request->all(), [
            'source_account' => 'required|exists:bank_accounts,id',
            'destination_iban' => 'required|exists:bank_accounts,iban',
            'amount' => 'required|numeric|min:0.01',
        ]);
        if ($validator->fails()) {
            return redirect()->back()->with(['error' => 'Something went wrong']);
        }
        // Retrieve the source and destination accounts
        $sourceAccount = BankAccount::findOrFail($request->source_account);
        $destinationAccount = BankAccount::where('iban', $request->destination_iban)->firstOrFail();
        // dd($destinationAccount);
        if ($sourceAccount->id === $destinationAccount->id) {
            DB::transaction(function () use ($sourceAccount, $request) {
                $creditTransaction = Transaction::create([
                    'bank_account_id' => $sourceAccount->id,
                    'amount'          => $request->amount,
                    'currency'        => 'EUR',
                    'type'            => 'CREDIT',
                    'related_account' => $sourceAccount->id, // Self-referencing
                ]);
    
                if (!$creditTransaction) {
                    return redirect()->back()->with(['error' => 'Something went wrong']);
                } else {
                    $sourceAccount->increment('balance', $request->amount);
                    return redirect()->route('transactions.index')
                    ->with(['success'=> 'Deposit completed successfully.']);
                }
            });
    
           
        }
      
        if (!$destinationAccount) {
            return redirect()->back()->with(['error' => 'Destination account not found.']);
        }
        // Check if the source account has enough balance
        if ($sourceAccount->balance < $request->amount) {
            return redirect()->back()->with(['error' => 'Insufficient balance in the source account.']);
        }

        // Check if the source account is linked to a debit card
        if (!$sourceAccount->cards()->exists()) {
            return redirect()->back()->with(['error', 'The source account is not linked to a debit card.']);
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
                return redirect()->back()->with(['error' => 'Something went wrong']);
              
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
                return redirect()->back()->with(['error' => 'Something went wrong']);

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


       
        if (Auth::user()->can('view_own_transactions')) {
            $transactionsQuery->whereHas('bankAccount', function ($query) {
                $query->where('client_id', Auth::id());
            });
        }
    
        $transactions = $transactionsQuery->get();
        return view('backend.banker.transactions', compact('transactions'));
    }
}
