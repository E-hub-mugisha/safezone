@extends('layouts.guest')

@section('content')
<div class="container">
    <h2 class="mb-4">Track Your Case</h2>
    <a href="{{ route('cases.download', $case->id) }}" class="btn btn-danger">
        Download Case Report (PDF)
    </a>

    {{-- Case Search Form --}}
    <form action="{{ route('case.track') }}" method="POST" class="mb-4">
        @csrf
        <div class="input-group">
            <input type="text" name="case_number" class="form-control" placeholder="Enter Case ID (e.g. SZC-2025-001)" required>
            <button type="submit" class="btn btn-primary">Track</button>
        </div>
    </form>

    {{-- Case Details --}}
    @isset($case)
    <div class="card mb-4">
        <div class="card-header">
            <strong>Case ID:</strong> {{ $case->case_number }}
        </div>
        <div class="card-body">
            <p><strong>Survivor:</strong> {{ $case->survivor_name }}</p>
            <p><strong>Type:</strong> {{ ucfirst($case->type) }}</p>
            <p><strong>Status:</strong>
                <span class="badge bg-{{ $case->status == 'resolved' ? 'success' : ($case->status == 'in_review' ? 'warning' : 'secondary') }}">
                    {{ ucfirst($case->status) }}
                </span>
            </p>
            <p><strong>Description:</strong> {{ $case->description }}</p>
            <p><strong>Location:</strong> {{ $case->location ?? 'N/A' }}</p>
        </div>
    </div>

    {{-- Existing Evidence --}}
    <div class="card mb-4">
        <div class="card-header">Submitted Evidence</div>
        <div class="card-body">
            @if($case->evidences->count() > 0)
            <ul>
                @foreach($case->evidences as $evidence)
                <li>
                    <a href="{{ asset('storage/'.$evidence->file_path) }}" target="_blank">
                        {{ basename($evidence->file_path) }}
                    </a>
                </li>
                @endforeach
            </ul>
            @else
            <p>No evidence submitted yet.</p>
            @endif
        </div>
    </div>

    {{-- Add More Evidence --}}
    <div class="card">
        <div class="card-header">Add More Evidence</div>
        <div class="card-body">
            <form action="{{ route('case.add.evidence', $case->id) }}" method="POST" enctype="multipart/form-data">
                @csrf
                <div class="mb-3">
                    <label for="evidences" class="form-label">Upload Evidence Files</label>
                    <input type="file" name="evidences[]" multiple class="form-control">
                </div>
                <button type="submit" class="btn btn-success">Submit Evidence</button>
            </form>
        </div>
    </div>
    @endisset
</div>
@endsection