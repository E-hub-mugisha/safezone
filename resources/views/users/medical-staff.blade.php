@extends('layouts.app')
@section('title', 'Medical Staff List')
@section('content')
<div class="container">
    <div class="d-flex justify-content-between align-items-center mb-3">
        <h3>Medical Staff Members</h3>
        <div>
            <a href="{{ route('dashboard') }}" class="btn btn-secondary">Back to Home</a>
            @if(Auth::user()->role === 'admin')
            <button class="btn btn-success" data-bs-toggle="modal" data-bs-target="#addStaffModal">
                <i class="bi bi-plus-circle"></i> Add Staff
            </button>
            @endif
        </div>
    </div>
    @if(session('success'))
        <div class="alert alert-success">{{ session('success') }}</div>
    @endif

    <table class="table table-bordered table-striped">
        <thead>
            <tr>
                <th>ID</th>
                <th>Name</th>
                <th>Email</th>
                <th>Role</th>
                <th>Action</th>
            </tr>
        </thead>
        <tbody>
            @forelse($medicalStaff as $user)
            <tr>
                <td>{{ $user->id }}</td>
                <td>{{ $user->name }}</td>
                <td>{{ $user->email }}</td>
                <td>{{ $user->role }}</td>
                <td>
                    <a href="mailto:{{ $user->email }}" class="btn btn-sm btn-primary" title="Email">
                        Email
                    </a>
                    @if(Auth::user()->role === 'admin')
                    <button class="btn btn-sm btn-warning" data-bs-toggle="modal" data-bs-target="#editStaffModal{{ $user->id }}" title="Edit">
                        Edit
                    </button>
                    <button class="btn btn-sm btn-danger" data-bs-toggle="modal" data-bs-target="#deleteStaffModal{{ $user->id }}" title="Delete">
                        Delete
                    </button>
                    @endif
                </td>
            </tr>
            @empty
            <tr>
                <td colspan="4" class="text-center">No medical staff found.</td>
            </tr>
            @endforelse
        </tbody>
    </table>

    @foreach($medicalStaff as $user)
    {{-- Edit Staff Modal --}}
    <div class="modal fade" id="editStaffModal{{ $user->id }}" tabindex="-1">
        <div class="modal-dialog">
            <form action="{{ route('users.update', $user->id) }}" method="POST" class="modal-content">
                @csrf
                @method('PUT')
                <div class="modal-header">
                    <h5 class="modal-title">Edit Staff - {{ $user->name }}</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
                </div>
                <div class="modal-body">
                    <div class="mb-3">
                        <label class="form-label">Name</label>
                        <input type="text" name="name" class="form-control" value="{{ $user->name }}" required>
                    </div>
                    <div class="mb-3">
                        <label class="form-label">Email</label>
                        <input type="email" name="email" class="form-control" value="{{ $user->email }}" required>
                    </div>
                    <div class="mb-3">
                        <label class="form-label">Role</label>
                        <select name="role" class="form-select" required>
                            <option value="medical" {{ $user->role=='medical'?'selected':'' }}>medical</option>
                        </select>
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cancel</button>
                    <button type="submit" class="btn btn-warning">Update</button>
                </div>
            </form>
        </div>
    </div>
    @endforeach

    @foreach($medicalStaff as $user)
    {{-- Delete Staff Modal --}}
    <div class="modal fade" id="deleteStaffModal{{ $user->id }}" tabindex="-1">
        <div class="modal-dialog">
            <form action="{{ route('users.destroy', $user->id) }}" method="POST" class="modal-content">
                @csrf
                @method('DELETE')
                <div class="modal-header">
                    <h5 class="modal-title text-danger">Delete Staff - {{ $user->name }}</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
                </div>
                <div class="modal-body">
                    Are you sure you want to delete this staff member permanently?
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cancel</button>
                    <button type="submit" class="btn btn-danger">Delete</button>
                </div>
            </form>
        </div>
    </div>
    @endforeach
    {{-- Add Staff Modal --}}
    <div class="modal fade" id="addStaffModal" tabindex="-1">
        <div class="modal-dialog">
            <form action="{{ route('users.store') }}" method="POST" class="modal-content">
                @csrf
                <div class="modal-header">
                    <h5 class="modal-title">Add New Staff</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
                </div>
                <div class="modal-body">
                    <div class="mb-3">
                        <label class="form-label">Name</label>
                        <input type="text" name="name" class="form-control" required>
                    </div>
                    <div class="mb-3">
                        <label class="form-label">Email</label>
                        <input type="email" name="email" class="form-control" required>
                    </div>
                    <div class="mb-3">
                        <label class="form-label">Role</label>
                        <select name="role" class="form-select" required>
                            <option value="">Select Role</option>
                            <option value="medical">medical</option>
                        </select>
                    </div>
                    <div class="mb-3">
                        <label class="form-label">Password</label>
                        <input type="password" name="password" class="form-control" required>
                    </div>
                    <div class="mb-3">
                        <label class="form-label">Confirm Password</label>
                        <input type="password" name="password_confirmation" class="form-control" required>
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="submit" class="btn btn-success">Add Staff</button>
                </div>
            </form>
        </div>
    </div>
</div>
@endsection