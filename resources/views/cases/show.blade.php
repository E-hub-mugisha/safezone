@extends('layouts.app')

@section('title', 'Case Detail')

@section('content')
<div class="container my-5">

    {{-- Case Information --}}
    <div class="card shadow-sm mb-4">
        <div class="card-header bg-primary text-white d-flex justify-content-between align-items-center">
            <div>
                <i class="bi bi-folder2-open me-2"></i> Case Detail - {{ $case->case_number }}
            </div>

            {{-- Dropdown Actions --}}
            <div class="dropdown">
                <button class="btn btn-light btn-sm dropdown-toggle" type="button" id="caseActionsDropdown"
                    data-bs-toggle="dropdown" aria-expanded="false">
                    <i class="bi bi-gear"></i> Actions
                </button>
                <ul class="dropdown-menu dropdown-menu-end" aria-labelledby="caseActionsDropdown">
                    <li>
                        <a href="{{ route('safe-zone-cases.showEvidence', $case->id) }}" class="dropdown-item">
                            <i class="bi bi-folder2"></i> Evidence
                        </a>
                    </li>
                    <li>
                        <button class="dropdown-item text-success" data-bs-toggle="modal" data-bs-target="#verifyModal{{ $case->id }}">
                            <i class="bi bi-check2-circle"></i> Verify
                        </button>
                    </li>
                    <li>
                        <button class="dropdown-item text-primary" data-bs-toggle="modal" data-bs-target="#assignModal{{ $case->id }}">
                            <i class="bi bi-person-plus"></i> Assign
                        </button>
                    </li>
                    <li>
                        <button class="dropdown-item text-danger" data-bs-toggle="modal" data-bs-target="#deleteModal{{ $case->id }}">
                            <i class="bi bi-trash"></i> Delete
                        </button>
                    </li>
                    <li>
                        <button class="dropdown-item text-warning" data-bs-toggle="modal" data-bs-target="#medicalModal{{ $case->id }}">
                            <i class="bi bi-file-earmark-medical"></i> Add Medical Report
                        </button>
                    </li>
                </ul>
            </div>
        </div>

        <div class="card-body">
            <div class="row g-4">
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
                    <p><strong>Assigned RIB Agent:</strong>
                        <span class="text-primary">{{ $case->agent->name ?? 'Not Assigned' }}</span>
                    </p>
                    <p><strong>Assigned Medical Staff:</strong>
                        <span class="text-success">{{ $case->medical->name ?? 'Not Assigned' }}</span>
                    </p>
                </div>
                <div class="col-12">
                    <p><strong>Description:</strong></p>
                    <div class="p-3 border rounded bg-light">
                        {{ $case->description }}
                    </div>
                </div>
            </div>
        </div>
    </div>

    <div class="row g-4">
        {{-- Case Notes --}}
        <div class="col-lg-4">
            <div class="card shadow-sm h-100">
                <div class="card-header bg-info text-white d-flex justify-content-between align-items-center">
                    <span><i class="bi bi-journal-text me-2"></i> Case Notes</span>
                    <button class="btn btn-light btn-sm" data-bs-toggle="modal" data-bs-target="#addNoteModal">
                        <i class="bi bi-plus-circle"></i> Add Note
                    </button>
                </div>
                <div class="card-body">
                    @if($case->notes->count() > 0)
                    <div class="list-group list-group-flush">
                        @foreach($case->notes as $note)
                        <div class="list-group-item">
                            <strong>{{ $note->user->name }}</strong>
                            <small class="text-muted">({{ $note->created_at->format('Y-m-d H:i') }})</small>
                            <p class="mb-1">{{ $note->note }}</p>
                        </div>
                        @endforeach
                    </div>
                    @else
                    <p class="text-muted">No notes have been added yet.</p>
                    @endif
                </div>
            </div>
        </div>
        {{-- Tracking Logs --}}
        <div class="col-lg-4">
            <div class="card shadow-sm h-100">
                <div class="card-header bg-warning text-dark">
                    <i class="bi bi-clock-history me-2"></i> Case History (Audit Trail)
                </div>
                <div class="card-body">
                    @if($case->trackingLogs->count() > 0)
                    <ul class="list-group list-group-flush">
                        @foreach($case->trackingLogs as $log)
                        <li class="list-group-item">
                            <strong>{{ $log->action }}</strong>
                            @if($log->user) by <span class="text-primary">{{ $log->user->name }}</span> @endif
                            <br>
                            <small class="text-muted">{{ $log->created_at->format('Y-m-d H:i') }}</small>
                            @if($log->details)
                            <div class="mt-1"><em>{{ $log->details }}</em></div>
                            @endif
                        </li>
                        @endforeach
                    </ul>
                    @else
                    <p class="text-muted">No activity recorded yet.</p>
                    @endif
                </div>
            </div>
        </div>
        {{-- Evidence --}}
        <div class="col-lg-4">
            <div class="card shadow-sm h-100">
                <div class="card-header bg-success text-white">
                    <i class="bi bi-folder-symlink me-2"></i> Evidences
                </div>
                <div class="card-body">
                    @if($case->evidences->count() > 0)
                    <ul class="list-group list-group-flush">
                        @foreach($case->evidences as $evidence)
                        <li class="list-group-item d-flex justify-content-between align-items-center">
                            {{ $evidence->description ?? $evidence->file_path }}
                            <a href="{{ asset('storage/'.$evidence->file_path) }}" target="_blank" class="btn btn-sm btn-outline-primary">
                                <i class="bi bi-eye"></i> View
                            </a>
                        </li>
                        @endforeach
                    </ul>
                    @else
                    <p class="text-muted">No evidences uploaded yet.</p>
                    @endif
                </div>
            </div>
        </div>
    </div>

    {{-- Add Note Modal --}}
    <div class="modal fade" id="addNoteModal" tabindex="-1">
        <div class="modal-dialog">
            <form action="{{ route('cases.notes.store', $case->id) }}" method="POST" class="modal-content">
                @csrf
                <div class="modal-header">
                    <h5 class="modal-title">Add Daily Note</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
                </div>
                <div class="modal-body">
                    <textarea name="note" class="form-control" rows="4" placeholder="Describe the progress or actions taken today..." required></textarea>
                </div>
                <div class="modal-footer">
                    <button type="submit" class="btn btn-info">Save Note</button>
                </div>
            </form>
        </div>
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
@endsection