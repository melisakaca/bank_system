@extends('layouts.master-new')

@section('content')
<div class="row">
    <div class="col-xl-12">
        <div class="">
            <div class="card-header align-items-center d-flex">
                <h4 class="card-title mb-0 flex-grow-1">Transactions</h4>
                <h4>  <a href="{{ route('transactions.create') }}" class="btn btn-primary">Create transaction</a></h4>
            </div>
            <div class="card-body">
                <div class="live-preview">
                    <div class="table-responsive table-card">
                        <table id="datatable-bank-accounts" class="table align-middle table-nowrap mb-0">
                            <thead class="table-light">
                                <tr>
                                    <th>IBAN</th>
                                    <th>Currency</th>
                                    <th>Balance</th>
                                    <th>Status</th>
                                    <th>Client Name</th>
                                    <th>Client Email</th>
                                    <th>Actions</th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach ($bankAccounts as $bankAccount)
                                    <tr>
                                        <td>{{ $bankAccount->iban }}</td>
                                        <td>{{ $bankAccount->currency }}</td>
                                        <td>{{ $bankAccount->balance }}</td>
                                        <td>{{ $bankAccount->status }}</td>
                                        <td>{{ $bankAccount->client->name ?? 'N/A' }}</td>
                                        <td>{{ $bankAccount->client->email ?? 'N/A' }}</td>
                                        <td>
                                            <a href="{{ route('bankAccounts.edit', $bankAccount) }}" class="btn btn-sm btn-warning">Edit</a>
                                            <form action="{{ route('bankAccounts.destroy', $bankAccount) }}" method="POST" style="display:inline;">
                                                @csrf
                                                @method('DELETE')
                                                <button type="submit" class="btn btn-sm btn-danger" onclick="return confirm('Are you sure?')">
                                                    Delete
                                                </button>
                                            </form>
                                        </td>
                                    </tr>
                                @endforeach
                            </tbody>
                        </table>
                    </div>
                    
                </div>
            </div>
        </div>
    </div>
</div>
@endsection