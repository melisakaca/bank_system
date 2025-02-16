@extends('layouts.app')

@section('content')
<!-- resources/views/client/request_card.blade.php -->
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
        <input type="number" name="monthly_salary" id="monthly_salary" class="form-control" step="0.01" required>
    </div>
    <button type="submit" class="btn btn-primary">Submit Request</button>
</form>
@endsection