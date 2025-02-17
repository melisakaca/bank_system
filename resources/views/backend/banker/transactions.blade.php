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
                        <table id="datatable-bankers" class="table align-middle table-nowrap mb-0">
                            <thead class="table-light">

                                <tr>
                                    <th>Name</th>
                                    <th>Email</th>
                                    {{-- <th>Actions</th> --}}
                                </tr>

                            </thead>
                            <tbody>
                                @foreach ($transactions as $transaction)
                                <tr>
                                    <td>{{ $transaction->name }}</td>
                                    <td>{{ $transaction->email }}</td>
                                    {{-- <td>
                                        <a href="{{ route('transactions.edit', $transaction) }}" class="btn btn-sm btn-warning">Edit</a>
                                        <form action="{{ route('transactions.destroy', $transaction) }}" method="POST" style="display:inline;">
                                            @csrf
                                            @method('DELETE')
                                            <button type="submit" class="btn btn-sm btn-danger" onclick="return confirm('Are you sure?')">Delete</button>
                                        </form>
                                    </td> --}}
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