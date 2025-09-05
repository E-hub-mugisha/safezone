@extends('layouts.app')

@section('title', 'Case Detail')

@section('content')
<div class="container my-5">

    {{-- Case Information --}}
    <div class="card mb-4 shadow-sm">
        <div class="card-header bg-primary text-white">
            Case Detail - {{ $case->case_number }}
        </div>
        <div class="card-body">
            <div class="row g-3">
                <div class="col-md-6">
                    <p><strong>Type:</strong> {{ ucfirst($case->type) }}</p>
                    <p><strong>Status:</strong>
                        <span class="badge 
                            @if($case->status=='pending') bg-warning
                            @elseif($case->status=='verified') bg-info
                            @elseif($case->status=='in_progress') bg-primary
                            @elseif($case->status=='resolved') bg-success
                            @endif
                        ">
                            {{ ucfirst(str_replace('_',' ',$case->status)) }}
                        </span>
                    </p>
                    <p><strong>Reported By:</strong> {{ $case->survivor_name }} ({{ $case->email }})</p>
                    <p><strong>Phone:</strong> {{ $case->phone ?? 'N/A' }}</p>
                </div>
                <div class="col-md-6">
                    <p><strong>Location:</strong> {{ $case->location ?? 'N/A' }}</p>
                    <p><strong>Assigned RIB Agent:</strong> {{ $case->agent->name ?? 'Not Assigned' }}</p>
                    <p><strong>Assigned Medical Staff:</strong> {{ $case->medical->name ?? 'Not Assigned' }}</p>
                </div>
                <div class="col-12">
                    <p><strong>Description:</strong></p>
                    <div class="p-3 border rounded bg-light">{{ $case->description }}</div>
                </div>
            </div>
        </div>
    </div>

    {{-- Evidence Section --}}
    <div class="card mb-4 shadow-sm">
        <div class="card-header bg-success text-white">
            Evidences
        </div>
        <div class="card-body">
            @if($case->evidences->count() > 0)
            <ul class="list-group">
                @foreach($case->evidences as $evidence)
                <li class="list-group-item d-flex justify-content-between align-items-center">
                    {{ $evidence->description ?? $evidence->file_path }}
                    <a href="{{ asset('storage/'.$evidence->file_path) }}" target="_blank" class="btn btn-sm btn-outline-primary">View</a>
                </li>
                @endforeach
            </ul>
            @else
            <p class="text-muted">No evidences uploaded yet.</p>
            @endif
        </div>
    </div>

    {{-- Tracking Logs --}}
    <div class="card mb-4 shadow-sm">
        <div class="card-header bg-warning text-dark">
            Case History (Audit Trail)
        </div>
        <div class="card-body">
            @if($case->trackingLogs->count() > 0)
            <ul class="list-group">
                @foreach($case->trackingLogs as $log)
                <li class="list-group-item">
                    <strong>{{ $log->action }}</strong>
                    @if($log->user) by <span class="text-primary">{{ $log->user->name }}</span> @endif
                    <br>
                    <small class="text-muted">{{ $log->created_at->format('Y-m-d H:i') }}</small>
                    @if($log->details)
                    <div><em>{{ $log->details }}</em></div>
                    @endif
                </li>
                @endforeach
            </ul>
            @else
            <p class="text-muted">No activity recorded yet.</p>
            @endif
        </div>
    </div>

    {{-- Actions --}}
    <div class="card mb-4 shadow-sm">
        <div class="card-header bg-secondary text-white">
            Actions
        </div>
        <div class="card-body d-flex flex-column p-3 gap-2">

            {{-- Action Buttons --}}
            <div class="d-flex flex-wrap gap-2 ">
                <a href="{{ route('safe-zone-cases.showEvidence', $case->id) }}" class="btn btn-outline-info btn-sm">
                    Evidence
                </a>
                <button class="btn btn-success btn-sm" data-bs-toggle="modal" data-bs-target="#verifyModal{{ $case->id }}">
                    Verify
                </button>
                <button class="btn btn-primary btn-sm" data-bs-toggle="modal" data-bs-target="#assignModal{{ $case->id }}">
                    Assign
                </button>
                <button class="btn btn-danger btn-sm" data-bs-toggle="modal" data-bs-target="#deleteModal{{ $case->id }}">
                    Delete
                </button>
                <button class="btn btn-warning btn-sm" data-bs-toggle="modal" data-bs-target="#medicalModal{{ $case->id }}">
                    Add Medical Report
                </button>
            </div>

            {{-- Verify Modal --}}
            <div class="modal fade" id="verifyModal{{ $case->id }}" tabindex="-1">
                <div class="modal-dialog">
                    <form action="{{ route('safe-zone-cases.update',$case->id) }}" method="POST" class="modal-content">
                        @csrf
                        @method('PATCH')
                        <input type="hidden" name="verify" value="1">
                        <div class="modal-header">
                            <h5 class="modal-title">Verify Case</h5>
                            <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
                        </div>
                        <div class="modal-body">
                            Are you sure you want to mark this case as <strong>verified</strong>?
                        </div>
                        <div class="modal-footer">
                            <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cancel</button>
                            <button type="submit" class="btn btn-success">Verify</button>
                        </div>
                    </form>
                </div>
            </div>

            {{-- Assign Modal --}}
            <div class="modal fade" id="assignModal{{ $case->id }}" tabindex="-1">
                <div class="modal-dialog">
                    <form action="{{ route('safe-zone-cases.update',$case->id) }}" method="POST" class="modal-content">
                        @csrf
                        @method('PATCH')
                        <input type="hidden" name="assign" value="1">
                        <div class="modal-header">
                            <h5 class="modal-title">Assign Case</h5>
                            <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
                        </div>
                        <div class="modal-body">
                            <div class="mb-3">
                                <label class="form-label">RIB Agent</label>
                                <select name="agent_id" class="form-select" required>
                                    <option value="">Select Agent</option>
                                    @foreach($agents as $agent)
                                    <option value="{{ $agent->id }}" {{ $case->agent_id == $agent->id ? 'selected' : '' }}>{{ $agent->name }}</option>
                                    @endforeach
                                </select>
                            </div>
                            <div class="mb-3">
                                <label class="form-label">Medical Staff</label>
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
                    </form>
                </div>
            </div>

            {{-- Delete Modal --}}
            <div class="modal fade" id="deleteModal{{ $case->id }}" tabindex="-1">
                <div class="modal-dialog">
                    <form action="{{ route('safe-zone-cases.destroy',$case->id) }}" method="POST" class="modal-content">
                        @csrf
                        @method('DELETE')
                        <div class="modal-header">
                            <h5 class="modal-title text-danger">Delete Case</h5>
                            <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
                        </div>
                        <div class="modal-body">
                            Are you sure you want to delete this case permanently?
                        </div>
                        <div class="modal-footer">
                            <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cancel</button>
                            <button type="submit" class="btn btn-danger">Delete</button>
                        </div>
                    </form>
                </div>
            </div>

            {{-- Medical Report Modal --}}
            <div class="modal fade" id="medicalModal{{ $case->id }}" tabindex="-1">
                <div class="modal-dialog">
                    <form action="{{ route('medical-reports.store', $case->id) }}" method="POST" enctype="multipart/form-data" class="modal-content">
                        @csrf
                        <div class="modal-header">
                            <h5 class="modal-title">Add Medical Report for {{ $case->case_number }}</h5>
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

        </div>
    </div>


</div>
@endsection