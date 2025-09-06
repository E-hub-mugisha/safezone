@extends('layouts.app')

@section('title','GBV Case Management')

@section('content')
<div class="container-fluid">
    <div class="d-flex justify-content-between align-items-center mb-4">
        <h2>Case Management</h2>
        <button type="button" class="btn btn-primary" data-bs-toggle="modal" data-bs-target="#addCaseModal">
            Add New Case
        </button>
    </div>

    <!-- Success Alert -->
    @if(session('success'))
    <div class="alert alert-success alert-dismissible fade show" role="alert">
        {{ session('success') }}
        <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
    </div>
    @endif

    <!-- Cases Table -->
    <div class="card card-bordered card-preview">
        <div class="card-inner">
            <div class="table-responsive">
                <table class="table table-bordered table-hover align-middle datatable-init-export nowrap" data-export-title="Export">
                    <thead class="table-light">
                        <tr>
                            <th>#</th>
                            <th>Case Number</th>
                            <th>Name</th>
                            <th>Email</th>
                            <th>Phone</th>
                            <th>Type</th>
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
                            <td><a href="{{ route('cases.show', $case->id) }}">{{ $case->case_number }}</a></td>
                            <td>{{ $case->survivor_name }}</td>
                            <td>{{ $case->email }}</td>
                            <td>{{ $case->phone }}</td>
                            <td>{{ ucfirst($case->type) }}</td>
                            <td>{{ $case->location ?? 'N/A' }}</td>
                            <td>
                                <span class="badge 
                            @if($case->status=='pending') bg-warning
                            @elseif($case->status=='verified') bg-info
                            @elseif($case->status=='in_progress') bg-primary
                            @elseif($case->status=='resolved') bg-success
                            @endif
                        ">
                                    {{ ucfirst(str_replace('_',' ',$case->status)) }}
                                </span>
                            </td>
                            <td>{{ $case->agent->name ?? '-' }}</td>
                            <td>{{ $case->medical->name ?? '-' }}</td>
                            <td>
                                <!-- Dropdown Actions -->
                                <div class="dropdown">
                                    <button class="btn btn-secondary btn-sm dropdown-toggle" type="button" id="actionsDropdown{{ $case->id }}" data-bs-toggle="dropdown" aria-expanded="false">
                                        Actions
                                    </button>
                                    <ul class="dropdown-menu dropdown-menu-end" aria-labelledby="actionsDropdown{{ $case->id }}">
                                        <li>
                                            <a class="dropdown-item" href="{{ route('cases.show', $case->id) }}">
                                                View Details
                                            </a>
                                        </li>
                                        <li>
                                            <a class="dropdown-item" href="{{ route('safe-zone-cases.showEvidence', $case->id) }}">
                                                Evidence
                                            </a>
                                        </li>
                                        <li>
                                            <button class="dropdown-item" data-bs-toggle="modal" data-bs-target="#verifyModal{{ $case->id }}">
                                                Verify
                                            </button>
                                        </li>
                                        <li>
                                            <button class="dropdown-item" data-bs-toggle="modal" data-bs-target="#assignModal{{ $case->id }}">
                                                Assign
                                            </button>
                                        </li>
                                        <li>
                                            <button class="dropdown-item text-danger" data-bs-toggle="modal" data-bs-target="#deleteModal{{ $case->id }}">
                                                Delete
                                            </button>
                                        </li>
                                        <li>
                                            <button class="dropdown-item" data-bs-toggle="modal" data-bs-target="#medicalModal{{ $case->id }}">
                                                Add Medical Report
                                            </button>
                                        </li>
                                    </ul>
                                </div>
                            </td>
                        </tr>

                        <!-- Verify Modal -->
                        <div class="modal fade" id="verifyModal{{ $case->id }}" tabindex="-1">
                            <div class="modal-dialog">
                                <form action="{{ route('safe-zone-cases.update',$case->id) }}" method="POST">
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
                                <form action="{{ route('safe-zone-cases.update',$case->id) }}" method="POST">
                                    @csrf
                                    @method('PATCH')
                                    <input type="hidden" name="assign" value="1">
                                    <div class="modal-content">
                                        <div class="modal-header">
                                            <h5 class="modal-title">Assign Case</h5>
                                            <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
                                        </div>
                                        <div class="modal-body">
                                            <div class="mb-3">
                                                <label>RIB Agent:</label>
                                                <select name="agent_id" class="form-select" required>
                                                    <option value="">Select Agent</option>
                                                    @foreach($agents as $agent)
                                                    <option value="{{ $agent->id }}" {{ $case->agent_id == $agent->id ? 'selected' : '' }}>{{ $agent->name }}</option>
                                                    @endforeach
                                                </select>
                                            </div>
                                            <div class="mb-3">
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
                                <form action="{{ route('safe-zone-cases.destroy',$case->id) }}" method="POST">
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

                        <!-- Medical Report Modal -->
                        <div class="modal fade" id="medicalModal{{ $case->id }}" tabindex="-1">
                            <div class="modal-dialog">
                                <form method="POST" action="{{ route('medical-reports.store', $case->id) }}" enctype="multipart/form-data" class="modal-content">
                                    @csrf
                                    <div class="modal-header">
                                        <h5 class="modal-title">Add Medical Report for Case {{ $case->case_number }}</h5>
                                        <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
                                    </div>
                                    <div class="modal-body">
                                        <div class="mb-3">
                                            <label class="form-label">Report Notes</label>
                                            <textarea name="report" class="form-control" rows="3"></textarea>
                                        </div>
                                        <div class="mb-3">
                                            <label class="form-label">Attach File (optional)</label>
                                            <input type="file" name="file" class="form-control" accept=".pdf,.doc,.docx,.jpg,.jpeg,.png">
                                        </div>
                                    </div>
                                    <div class="modal-footer">
                                        <button type="submit" class="btn btn-success">Save Report</button>
                                    </div>
                                </form>
                            </div>
                        </div>

                        @endforeach
                    </tbody>
                </table>
            </div>
        </div>
    </div>
    <!-- Add Case Modal -->
    <div class="modal fade" id="addCaseModal" tabindex="-1" aria-labelledby="addCaseModalLabel" aria-hidden="true">
        <div class="modal-dialog modal-lg">
            <form action="{{ route('safe-zone-cases.store') }}" method="POST">
                @csrf
                <div class="modal-content">
                    <div class="modal-header">
                        <h5 class="modal-title" id="addCaseModalLabel">Add New GBV Case</h5>
                        <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
                    </div>
                    <div class="modal-body">
                        <div class="row g-3">
                            <div class="col-md-6">
                                <label for="survivor_name" class="form-label">Survivor Name</label>
                                <input type="text" name="survivor_name" id="survivor_name" class="form-control" required>
                            </div>
                            <div class="col-md-6">
                                <label for="email" class="form-label">Email</label>
                                <input type="email" name="email" id="email" class="form-control" required>
                            </div>
                            <div class="col-md-6">
                                <label for="phone" class="form-label">Phone</label>
                                <input type="text" name="phone" id="phone" class="form-control" required>
                            </div>
                            <div class="col-md-6">
                                <label for="agent_id" class="form-label">Assign RIB Agent</label>
                                <select name="agent_id" id="agent_id" class="form-select">
                                    <option value="">Select Agent (Optional)</option>
                                    @foreach($agents as $agent)
                                    <option value="{{ $agent->id }}">{{ $agent->name }}</option>
                                    @endforeach
                                </select>
                            </div>
                            <div class="col-md-6">
                                <label for="medical_id" class="form-label">Assign Medical Staff</label>
                                <select name="medical_id" id="medical_id" class="form-select">
                                    <option value="">Select Medical Staff (Optional)</option>
                                    @foreach($medicalStaff as $staff)
                                    <option value="{{ $staff->id }}">{{ $staff->name }}</option>
                                    @endforeach
                                </select>
                            </div>
                            <div class="col-md-6">
                                <label for="type" class="form-label">Case Type</label>
                                <select name="type" id="type" class="form-select" required>
                                    <option value="">Select Type</option>
                                    <option value="physical">Physical</option>
                                    <option value="sexual">Sexual</option>
                                    <option value="psychological">Psychological</option>
                                </select>
                            </div>
                            <div class="col-12">
                                <label for="description" class="form-label">Description</label>
                                <textarea name="description" id="description" class="form-control" rows="3" required></textarea>
                            </div>
                            <div class="col-md-6">
                                <label for="location" class="form-label">Location (Optional)</label>
                                <input type="text" name="location" id="location" class="form-control">
                            </div>
                            <div class="col-md-6">
                                <label for="status" class="form-label">Status</label>
                                <select name="status" id="status" class="form-select" required>
                                    <option value="pending">Pending</option>
                                    <option value="verified">Verified</option>
                                    <option value="in_progress">In Progress</option>
                                    <option value="resolved">Resolved</option>
                                </select>
                            </div>
                        </div>
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
                        <button type="submit" class="btn btn-primary">Add Case</button>
                    </div>
                </div>
            </form>
        </div>
    </div>
</div>
@endsection