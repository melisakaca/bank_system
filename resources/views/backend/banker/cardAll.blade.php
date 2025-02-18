@extends('layouts.master-new')

@section('content')
    <div class="row">
        <div class="col-xl-12">
            <div class="card">
                <div class="card-header align-items-center d-flex mb-3">
                    <h4 class="card-title mb-0 flex-grow-1">Cards</h4>
                    @can('request_debit_card')
                     
                    <h4>  <a href="{{ route('card-requests.create') }}" class="btn btn-primary">Request New Debit Card</a></h4> @endcan
                </div>
                <div class="card-body">
                    <div class="live-preview">
                        <div class="table-responsive table-card">
                            <table id="datatable-cards" class="table align-middle table-nowrap mb-0">
                                <thead class="table-light">
                                    <tr>
                                        <th>Client</th>
                                        <th>Card Number</th>
                                        <th>Expiry Date</th>
                                        <th>CVV</th>
                                        <th>Status</th>
                                        <th>Bank Account IBAN</th>

                                        {{-- <th>Actions</th> --}}
                                    </tr>
                                </thead>
                                <tbody>
                                    @foreach ($cards as $card)
                                        <tr>
                                            <td>{{ $card->bankAccount->client->name }}</td>
                                            <td>{{ $card->card_number }}</td>
                                            <td>{{ $card->expiry_date }}</td>
                                            <td>{{ $card->cvv }}</td>
                                            <td>{{ $card->status }}</td>
                                            <td>{{ $card->bankAccount->iban ?? 'N/A' }}</td>
                                            {{-- Uncomment the following block if you need edit and delete actions --}}
                                            {{-- 
                                        <td>
                                            <a href="{{ route('cards.edit', $card) }}" class="btn btn-sm btn-warning">Edit</a>
                                            <form action="{{ route('cards.destroy', $card) }}" method="POST" style="display:inline;">
                                                @csrf
                                                @method('DELETE')
                                                <button type="submit" class="btn btn-sm btn-danger" onclick="return confirm('Are you sure?')">
                                                    Delete
                                                </button>
                                            </form>
                                        </td>
                                        --}}
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
