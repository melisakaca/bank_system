@extends('layouts.master-new')

@section('content')
<!-- resources/views/banker/card_requests.blade.php -->
<table class="table">
    <thead>
        <tr>
            <th>Client</th>
            <th>Bank Account</th>
            <th>Monthly Salary</th>
            <th>Status</th>
            <th>Actions</th>
        </tr>
    </thead>
    <tbody>
        @foreach ($cardRequests as $request)
            <tr>
                <td>{{ $request->client->name }}</td>
                <td>{{ $request->bankAccount->iban }}</td>
                <td>€{{ number_format($request->monthly_salary, 2) }}</td>
                <td>{{ $request->status }}</td>
                <td>
                    <form action="{{ route('card-requests.approve', $request->id) }}" method="POST" style="display:inline;">
                        @csrf
                        @method('PUT')
                        <button type="submit" class="btn btn-success">Approve</button>
                    </form>
                    <button type="button" class="btn btn-danger" data-bs-toggle="modal" data-bs-target="#disapproveModal" data-request-id="{{ $request->id }}">
                    Disapprove
                </button>
                </td>
            </tr>
        @endforeach
    </tbody>
</table>
@include('backend.partials.modals.disapprove-card-request')
@endsection