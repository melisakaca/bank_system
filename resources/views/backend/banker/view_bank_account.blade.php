@extends('layouts.master-new')

@section('content')
<div class="row">
    <div class="col-xl-12">
        <div class="card">
            <div class="card-header align-items-center d-flex">
                <h4 class="card-title mb-0 flex-grow-1">Transactions</h4>
             @can('perform_transactions')
                 
               <h4>  <a href="{{ route('transactions.create') }}" class="btn btn-primary">Create transaction</a></h4> @endcan
            </div>
            <div class="card-body">
                <div class="live-preview">
                    <div class="table-responsive table-card">
                        <table id="datatable-transactions" class="table align-middle table-nowrap mb-0">
                            <thead class="table-light">
                                <tr>
                                    <th>Transaction ID</th>
                                    <th>Client Name</th>
                                    <th>Client Email</th>
                                    <th>Amount</th>
                                    <th>Currency</th>
                                    <th>Type</th>
                                    <th>Date</th>
                                  
                                </tr>
                            </thead>
                            <tbody>
                                @foreach ($transactions as $transaction)
                                    <tr>
                                        <td>{{ $transaction->id }}</td>
                                        <td>{{ $transaction->bankAccount->client->name ?? 'N/A' }}</td>
                                        <td>{{ $transaction->bankAccount->client->email ?? 'N/A' }}</td>
                                        <td>{{ $transaction->amount }} €</td>
                                        <td>{{ $transaction->currency }}</td>
                                        <td>{{ $transaction->type }}</td>
                                        <td>{{ $transaction->created_at->format('d M, Y') }}</td>
                                        
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