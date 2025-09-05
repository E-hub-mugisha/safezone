@extends('layouts.app')
@section('title', 'Medical Staff List')
@section('content')
<div class="container">
    <h3>Medical Staff List</h3>
    <a href="{{ route('dashboard') }}" class="btn btn-secondary mb-3">Back to Dashboard</a>

    @if(session('success'))
        <div class="alert alert-success">{{ session('success') }}</div>
    @endif

    <table class="table table-bordered table-striped">
        <thead>
            <tr>
                <th>Name</th>
                <th>Email</th>
                <th>Phone</th>
                <th>Specialization</th>
            </tr>
        </thead>
        <tbody>
            @forelse($medicalStaff as $staff)
            <tr>
                <td>{{ $staff->name }}</td>
                <td>{{ $staff->email }}</td>
                <td>{{ $staff->phone }}</td>
                <td>{{ $staff->specialization }}</td>
            </tr>
            @empty
            <tr>
                <td colspan="4" class="text-center">No medical staff found.</td>
            </tr>
            @endforelse
        </tbody>
    </table>
</div>
@endsection