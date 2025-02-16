@extends('layouts.app')

@section('content')
    <h1>Bankers</h1>
    <a href="{{ route('bankers.create') }}" class="btn btn-primary">Create Banker</a>
    <table class="table">
        <thead>
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
                        <a href="{{ route('bankers.edit', $banker) }}" class="btn btn-sm btn-warning">Edit</a>
                        <form action="{{ route('bankers.destroy', $banker) }}" method="POST" style="display:inline;">
                            @csrf
                            @method('DELETE')
                            <button type="submit" class="btn btn-sm btn-danger" onclick="return confirm('Are you sure?')">Delete</button>
                        </form>
                    </td>
                </tr>
            @endforeach
        </tbody>
    </table>
@endsection