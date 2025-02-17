@extends('layouts.master-new')

@section('content')
    <div class="row">
        <div class="col-xl-12">
            <div class="">
                <div class="card-header align-items-center d-flex">
                    <h4 class="card-title mb-0 flex-grow-1">Bankers</h4>
                    <h4> <a href="{{ route('bankers.create') }}" class="btn btn-primary">Create Banker</a></h4>
                </div>
                <div class="card-body">
                    <div class="live-preview">
                        <div class="table-responsive table-card">
                            <table id="datatable-bankers" class="table align-middle table-nowrap mb-0">
                                <thead class="table-light">

                                    <tr>
                                        <th>Name</th>
                                        <th>Email</th>
                                        <th>Actions</th>
                                    </tr>

                                </thead>
                                <tbody>
                                    @foreach ($bankers as $banker)
                                        <tr>
                                            <td>{{ $banker->name }}</td>
                                            <td>{{ $banker->email }}</td>
                                            <td>
                                                <a href="{{ route('bankers.edit', $banker) }}"
                                                    class="btn btn-sm btn-warning">Edit</a>
                                                <form action="{{ route('bankers.destroy', $banker) }}" method="POST"
                                                    style="display:inline;">
                                                    @csrf
                                                    @method('DELETE')
                                                    <button type="submit" class="btn btn-sm btn-danger"
                                                        onclick="return confirm('Are you sure?')">Delete</button>
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
    {{-- <x-table 
    tableName="Bankers"
    title="Our Bankers" 
    :bankers="$bankers" 
    :columns="['Full Name', 'Email Address', 'Operations']" 
    createUrl="{{ route('bankers.create') }}"
    createText="Create Banker"
    editRouteName="{{route('bankers.edit') }}"
    destroyRouteName="{{ route('bankers.destroy') }}"
/> --}}

@endsection
