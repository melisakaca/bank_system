@extends('layouts.master-new')

@section('content')
<div class="container">
    <h1>Request New Bank Account</h1>
    <form action="{{ route('bank-accounts.store') }}" method="POST">
        @csrf
        <div class="form-group">
            <label for="currency">Currency</label>
            <select name="currency" id="currency" class="form-control" required>
                <option value="EUR">EUR</option>
            </select>
        </div>
        <button type="submit" class="btn btn-primary mt-4">Submit Request</button>
    </form>
</div>
@endsection