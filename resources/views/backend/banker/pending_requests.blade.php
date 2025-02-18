<!-- resources/views/banker/pending_requests.blade.php -->
@extends('layouts.master-new')

@section('content')
    <div class="row">
        <div class="col-xl-12">
            <div class="card">
                <div class="card-header align-items-center d-flex mb-3">
                    <h4 class="card-title mb-0 flex-grow-1">Pending Bank Account Requests</h4>

                </div>
                <div class="card-body">
                    <div class="live-preview">

                        <table id="datatable-pending_requests" class="table align-middle table-nowrap mb-0">
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
                                            <form action="{{ route('bank-accounts.approve', $request->id) }}" method="POST"
                                                style="display:inline;">
                                                @csrf
                                                @method('PUT')
                                                <button type="submit" class="btn btn-success">Approve</button>
                                            </form>
                                            <form action="{{ route('bank-accounts.disapprove', $request->id) }}"
                                                method="POST" style="display:inline;">
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
                </div>
            </div>
        </div>
    @endsection
