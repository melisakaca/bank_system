@extends('layouts.master-new')

@section('content')
    <div class="container">
        <h1>Request New Debit Card</h1>
        <form action="{{ route('card-requests.store') }}" method="POST">
            @csrf
            <div class="form-group">
                <label for="bank_account_id">Select Bank Account</label>
                <select name="bank_account_id" id="bank_account_id" class="form-control" required>
                    @foreach ($bankAccounts as $account)
                        <option value="{{ $account->id }}">{{ $account->iban }}</option>
                    @endforeach
                </select>
            </div>
            <div class="form-group">
                <label for="monthly_salary">Monthly Salary (€)</label>
                <input type="number" name="monthly_salary" id="monthly_salary" class="form-control" step="0.01"
                    required>
            </div>
            <button type="submit" class="btn btn-primary mt-4">Submit Request</button>
        </form>
    </div>
@endsection
