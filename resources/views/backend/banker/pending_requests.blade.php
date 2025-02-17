<!-- resources/views/banker/pending_requests.blade.php -->
@extends('layouts.master-new')

@section('content')
<div class="container">
    <h1>Pending Bank Account Requests</h1>
    <table class="table">
        <thead>
            <tr>
                <th>IBAN</th>
                <th>Currency</th>
                <th>Client</th>
                <th>Status</th>
                <th>Actions</th>
            </tr>
        </thead>
        <tbody>
            @foreach ($pendingRequests as $request)
                <tr>
                    <td>{{ $request->iban }}</td>
                    <td>{{ $request->currency }}</td>
                    <td>{{ $request->client->name }}</td>
                    <td>{{ $request->status }}</td>
                    <td>
                        <form action="{{ route('bank-accounts.approve', $request->id) }}" method="POST" style="display:inline;">
                            @csrf
                            @method('PUT')
                            <button type="submit" class="btn btn-success">Approve</button>
                        </form>
                        <form action="{{ route('bank-accounts.disapprove', $request->id) }}" method="POST" style="display:inline;">
                            @csrf
                            @method('PUT')
                            <button type="submit" class="btn btn-danger">Disapprove</button>
                        </form>
                    </td>
                </tr>
            @endforeach
        </tbody>
    </table>
</div>
@endsection