@extends('layouts.app')
@section('title', 'Reporter List')
@section('content')
<div class="container">
    <h3>Reporter List</h3>
    <a href="{{ route('dashboard') }}" class="btn btn-secondary mb-3">Back to Dashboard</a>

    @if(session('success'))
        <div class="alert alert-success">{{ session('success') }}</div>
    @endif

    <table class="table table-bordered table-striped">
        <thead>
            <tr>
                <th>Survivor Name</th>
                <th>Email</th>
                <th>Phone</th>
                <th>Action</th>
            </tr>
        </thead>
        <tbody>
            @forelse($reporters as $reporter)
            <tr>
                <td>{{ $reporter->survivor_name }}</td>
                <td>{{ $reporter->email }}</td>
                <td>{{ $reporter->phone }}</td>
                <td>
                    <a href="mailto:{{ $reporter->email }}" class="btn btn-sm btn-primary" title="Email">
                        Email
                    </a>
                    @if(Auth::user()->role === 'admin')
                    <button class="btn btn-sm btn-danger" data-bs-toggle="modal" data-bs-target="#deleteStaffModal{{ $reporter->id }}" title="Delete">
                        Delete
                    </button>
                    @endif
                </td>
            </tr>
            @empty
            <tr>
                <td colspan="3" class="text-center">No reporters found.</td>
            </tr>
            @endforelse
        </tbody>
    </table>

    @foreach($reporters as $reporter)
    {{-- Delete Staff Modal --}}
    <div class="modal fade" id="deleteStaffModal{{ $reporter->id }}" tabindex="-1">
        <div class="modal-dialog">
            <form action="{{ route('reporters.destroy', $reporter->email) }}" method="POST" class="modal-content">
                @csrf
                @method('DELETE')
                <div class="modal-header">
                    <h5 class="modal-title text-danger">Delete - {{ $reporter->survivor_name }}</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
                </div>
                <div class="modal-body">
                    Are you sure you want to delete this {{ $reporter->survivor_name }} reporter permanently?
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cancel</button>
                    <button type="submit" class="btn btn-danger">Delete</button>
                </div>
            </form>
        </div>
    </div>
    @endforeach

</div>
@endsection