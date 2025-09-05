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
            </tr>
        </thead>
        <tbody>
            @forelse($reporters as $reporter)
            <tr>
                <td>{{ $reporter->survivor_name }}</td>
                <td>{{ $reporter->email }}</td>
                <td>{{ $reporter->phone }}</td>
            </tr>
            @empty
            <tr>
                <td colspan="3" class="text-center">No reporters found.</td>
            </tr>
            @endforelse
        </tbody>
    </table>
</div>
@endsection