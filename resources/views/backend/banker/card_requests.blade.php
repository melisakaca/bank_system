@extends('layouts.master-new')

@section('content')
    <!-- resources/views/banker/card_requests.blade.php -->
    <div class="row">
        <div class="col-xl-12">
            <div class="card">
                <div class="card-header align-items-center d-flex mb-3">
                    <h4 class="card-title mb-0 flex-grow-1">Cards</h4>
                    @can('request_debit_card')
                        <h4> <a href="{{ route('card-requests.create') }}" class="btn btn-primary">Request New Debit Card</a></h4>
                    @endcan
                </div>
                <div class="card-body">
                    <div class="live-preview">
                        <div class="table-responsive table-card">
                            <table id="datatable-card-request" class="table align-middle table-nowrap mb-0">
                                <thead>
                                    <tr>
                                        <th>Client</th>
                                        <th>Bank Account</th>
                                        <th>Monthly Salary</th>
                                        <th>Status</th>
                                        <th>Comment</th>


                                        @can('approve_debit_cards')
                                            <th>Actions</th>
                                        @endcan
                                    </tr>
                                </thead>
                                <tbody>
                                    @foreach ($cardRequests as $request)
                                        <tr>
                                            <td>{{ $request->client->name }}</td>
                                            <td>{{ $request->bankAccount->iban }}</td>
                                            <td>€{{ number_format($request->monthly_salary, 2) }}</td>
                                            <td>{{ $request->status }}</td>
                                            <td>{{ $request->reason ?? '-' }}</td>

                                            @can('approve_debit_cards')
                                                <td>
                                                    <form action="{{ route('card-requests.approve', $request->id) }}"
                                                        method="POST" style="display:inline;">
                                                        @csrf
                                                        @method('PUT')
                                                        <button type="submit" class="btn btn-success">Approve</button>
                                                    </form>
                                                    <button type="button" class="btn btn-danger" data-bs-toggle="modal"
                                                        data-bs-target="#disapproveModal" data-request-id="{{ $request->id }}">
                                                        Disapprove
                                                    </button>
                                                </td>
                                            @endcan
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

    @include('backend.partials.modals.disapprove-card-request')
@endsection
