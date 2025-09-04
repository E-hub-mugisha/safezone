@extends('layouts.app')

@section('title', 'Case Detail')

@section('content')
<div class="container my-5">

    <div class="card mb-4">
        <div class="card-header bg-primary text-white">
            Case Detail - {{ $case->case_number }}
        </div>
        <div class="card-body">
            <p><strong>Type:</strong> {{ ucfirst($case->type) }}</p>
            <p><strong>Status:</strong> <span class="badge bg-info">{{ ucfirst($case->status) }}</span></p>
            <p><strong>Reported By:</strong> {{ $case->survivor_name }} ({{ $case->email }})</p>
            <p><strong>Location:</strong> {{ $case->location ?? 'N/A' }}</p>
            <p><strong>Description:</strong> {{ $case->description }}</p>
            <p><strong>Assigned RIB Agent:</strong> {{ $case->agent->name ?? 'Not Assigned' }}</p>
            <p><strong>Assigned Medical Staff:</strong> {{ $case->medical->name ?? 'Not Assigned' }}</p>
        </div>
    </div>

    {{-- Evidence Section --}}
    <div class="card mb-4">
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
                <p>No evidences uploaded yet.</p>
            @endif
        </div>
    </div>

    {{-- Tracking Logs --}}
    <div class="card mb-4">
        <div class="card-header bg-warning text-dark">
            Case History (Audit Trail)
        </div>
        <div class="card-body">
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
        </div>
    </div>

    {{-- Actions for RIB / Medical Staff --}}
    @if(auth()->user()->hasRole('rib') || auth()->user()->hasRole('medical'))
        <div class="card mb-4">
            <div class="card-header bg-secondary text-white">
                Actions
            </div>
            <div class="card-body">
                {{-- Example: Verify Case --}}
                @if(auth()->user()->hasRole('rib') && $case->status === 'pending')
                    <form action="{{ route('cases.verify', $case->id) }}" method="POST">
                        @csrf
                        <button type="submit" class="btn btn-success mb-2">Verify Case</button>
                    </form>
                @endif

                {{-- Example: Assign Medical Staff --}}
                @if(auth()->user()->hasRole('rib'))
                    <form action="{{ route('cases.assignMedical', $case->id) }}" method="POST" class="mb-2">
                        @csrf
                        <select name="medical_id" class="form-select mb-2">
                            @foreach($medicalStaff as $staff)
                                <option value="{{ $staff->id }}" {{ $case->medical_id == $staff->id ? 'selected' : '' }}>{{ $staff->name }}</option>
                            @endforeach
                        </select>
                        <button type="submit" class="btn btn-primary">Assign Medical Staff</button>
                    </form>
                @endif

                {{-- Upload Medical Report --}}
                @if(auth()->user()->hasRole('medical'))
                    <form action="{{ route('medical-reports.store', $case->id) }}" method="POST" enctype="multipart/form-data">
                        @csrf
                        <div class="mb-2">
                            <input type="file" name="report_file" class="form-control" required>
                        </div>
                        <button type="submit" class="btn btn-info">Upload Medical Report</button>
                    </form>
                @endif
            </div>
        </div>
    @endif

</div>
@endsection
