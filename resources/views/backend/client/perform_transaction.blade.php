@extends('layouts.master-new')

@section('content')
    <!-- resources/views/client/perform_transaction.blade.php -->
    <div class="container">


        <form action="{{ route('transactions.store') }}" method="POST">
            @csrf
            <div class="form-group">
                <label for="source_account">Source Account</label>
                <select name="source_account" id="source_account" class="form-control" required>
                    @foreach ($bankAccounts as $account)
                        <option value="{{ $account->id }}">{{ $account->iban }}</option>
                    @endforeach
                </select>
            </div>
            <div class="form-group">
                <label for="destination_iban">Destination IBAN</label>
                <input type="text" name="destination_iban" id="destination_iban" class="form-control" required>
            </div>
            <div class="form-group">
                <label for="amount">Amount (€)</label>
                <input type="number" name="amount" id="amount" class="form-control" step="0.01" required>
            </div>
            <input type="hidden" name="transaction_type" value="DEBIT">
            <button type="submit" class="btn btn-primary mt-4">Perform Transaction</button>

        </form>
    </div>
@endsection
