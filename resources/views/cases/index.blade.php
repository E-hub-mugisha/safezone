@extends('layouts.app')

@section('title','GBV Case Management')

@section('content')
<div class="container">
    <h2 class="mb-4">GBV Case Management</h2>

    <a href="{{ route('safe_zone_cases.create') }}" class="btn btn-success mb-3">Report New Case</a>

    @if(session('success'))
        <div class="alert alert-success">{{ session('success') }}</div>
    @endif

    <table class="table table-bordered table-striped">
        <thead class="table-dark">
            <tr>
                <th>#</th>
                <th>Reporter</th>
                <th>Type</th>
                <th>Description</th>
                <th>Location</th>
                <th>Status</th>
                <th>Agent</th>
                <th>Medical Staff</th>
                <th>Actions</th>
            </tr>
        </thead>
        <tbody>
            @foreach($cases as $case)
            <tr>
                <td>{{ $loop->iteration }}</td>
                <td>{{ $case->user->name }}</td>
                <td>{{ ucfirst($case->type) }}</td>
                <td>{{ $case->description }}</td>
                <td>{{ $case->location ?? 'N/A' }}</td>
                <td>{{ ucfirst($case->status) }}</td>
                <td>{{ $case->agent->name ?? '-' }}</td>
                <td>{{ $case->medical->name ?? '-' }}</td>
                <td>
                    <!-- Show -->
                    <a href="{{ route('safe_zone_cases.show',$case->id) }}" class="btn btn-info btn-sm">Show</a>
                    
                    <!-- Verify Modal -->
                    <button class="btn btn-success btn-sm" data-bs-toggle="modal" data-bs-target="#verifyModal{{ $case->id }}">Verify</button>
                    
                    <!-- Assign Modal -->
                    <button class="btn btn-primary btn-sm" data-bs-toggle="modal" data-bs-target="#assignModal{{ $case->id }}">Assign</button>

                    <!-- Delete Modal -->
                    <button class="btn btn-danger btn-sm" data-bs-toggle="modal" data-bs-target="#deleteModal{{ $case->id }}">Delete</button>
                </td>
            </tr>

            <!-- Verify Modal -->
            <div class="modal fade" id="verifyModal{{ $case->id }}" tabindex="-1">
                <div class="modal-dialog">
                    <form action="{{ route('safe_zone_cases.update',$case->id) }}" method="POST">
                        @csrf
                        @method('PATCH')
                        <input type="hidden" name="verify" value="1">
                        <div class="modal-content">
                            <div class="modal-header">
                                <h5 class="modal-title">Verify Case</h5>
                                <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
                            </div>
                            <div class="modal-body">
                                Mark this case as <strong>verified</strong>?
                            </div>
                            <div class="modal-footer">
                                <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cancel</button>
                                <button type="submit" class="btn btn-success">Verify</button>
                            </div>
                        </div>
                    </form>
                </div>
            </div>

            <!-- Assign Modal -->
            <div class="modal fade" id="assignModal{{ $case->id }}" tabindex="-1">
                <div class="modal-dialog">
                    <form action="{{ route('safe_zone_cases.update',$case->id) }}" method="POST">
                        @csrf
                        @method('PATCH')
                        <input type="hidden" name="assign" value="1">
                        <div class="modal-content">
                            <div class="modal-header">
                                <h5 class="modal-title">Assign Case</h5>
                                <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
                            </div>
                            <div class="modal-body">
                                <div class="mb-2">
                                    <label>RIB Agent:</label>
                                    <select name="agent_id" class="form-select" required>
                                        <option value="">Select Agent</option>
                                        @foreach($agents as $agent)
                                            <option value="{{ $agent->id }}" {{ $case->agent_id == $agent->id ? 'selected' : '' }}>{{ $agent->name }}</option>
                                        @endforeach
                                    </select>
                                </div>
                                <div class="mb-2">
                                    <label>Medical Staff:</label>
                                    <select name="medical_id" class="form-select" required>
                                        <option value="">Select Medical Staff</option>
                                        @foreach($medicalStaff as $staff)
                                            <option value="{{ $staff->id }}" {{ $case->medical_id == $staff->id ? 'selected' : '' }}>{{ $staff->name }}</option>
                                        @endforeach
                                    </select>
                                </div>
                            </div>
                            <div class="modal-footer">
                                <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cancel</button>
                                <button type="submit" class="btn btn-primary">Assign</button>
                            </div>
                        </div>
                    </form>
                </div>
            </div>

            <!-- Delete Modal -->
            <div class="modal fade" id="deleteModal{{ $case->id }}" tabindex="-1">
                <div class="modal-dialog">
                    <form action="{{ route('safe_zone_cases.destroy',$case->id) }}" method="POST">
                        @csrf
                        @method('DELETE')
                        <div class="modal-content">
                            <div class="modal-header">
                                <h5 class="modal-title">Delete Case</h5>
                                <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
                            </div>
                            <div class="modal-body">
                                Are you sure you want to delete this case?
                            </div>
                            <div class="modal-footer">
                                <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cancel</button>
                                <button type="submit" class="btn btn-danger">Delete</button>
                            </div>
                        </div>
                    </form>
                </div>
            </div>

            @endforeach
        </tbody>
    </table>
</div>
@endsection
