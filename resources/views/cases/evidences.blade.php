@extends('layouts.app')
@section('title', 'Case Evidences')
@section('content')
<div class="container">
    <h3>Case Evidences for Case #{{ $case->id }} - {{ $case->title }}</h3>
    <a href="{{ route('safe-zone-cases.index') }}" class="btn btn-secondary mb-3">Back to Cases</a>

    @if(session('success'))
        <div class="alert alert-success">{{ session('success') }}</div>
    @endif

    <table class="table table-bordered table-striped">
        <thead>
            <tr>
                <th>ID</th>
                <th>Type</th>
                <th>Description</th>
                <th>Uploaded At</th>
                <th>Actions</th>
            </tr>
        </thead>
        <tbody>
            @foreach($case->evidences as $evidence)
            <tr>
                <td>{{ $evidence->id }}</td>
                <td>{{ ucfirst($evidence->type) }}</td>
                <td>{{ $evidence->description }}</td>
                <td>{{ $evidence->created_at->format('Y-m-d H:i') }}</td>
                <td>
                    <a href="{{ asset('storage/' . $evidence->file_path) }}" target="_blank" class="btn btn-sm btn-primary">View</a>
                    <a href="{{ asset('storage/' . $evidence->file_path) }}" download class="btn btn-sm btn-success">Download</a>
                </td>
            </tr>
            @endforeach
        </tbody>
    </table>

    <!-- Add Evidence Modal Trigger -->
    <button class="btn btn-primary" data-bs-toggle="modal" data-bs-target="#addEvidenceModal">Add Evidence</button>

    <!-- Add Evidence Modal -->
    <div class="modal fade" id="addEvidenceModal" tabindex="-1" aria-labelledby="addEvidenceModalLabel" aria-hidden="true">
        <div class="modal-dialog">
            <form action="{{ route('safe-zone-cases.addEvidence', $case->id ) }}" method="POST" enctype="multipart/form-data">
                @csrf
                <input type="hidden" name="case_id" value="{{ $case->id }}">
                <div class="modal-content">
                    <div class="modal-header">
                        <h5 class="modal-title" id="addEvidenceModalLabel">Add New Evidence</h5>
                        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                    </div>
                    <div class="modal-body">
                        <div class="mb-3">
                            <label class="form-label">Type</label>
                            <select name="type" class="form-select" required>
                                <option value="image">Image</option>
                                <option value="video">Video</option>
                                <option value="document">Document</option>
                                <option value="other">Other</option>
                            </select>
                        </div>
                        <div class="mb-3">
                            <label class="form-label">Description</label>
                            <textarea name="description" class="form-control" rows="3" required></textarea>
                        </div>
                        <div class="mb-3">
                            <label class="form-label">File</label>
                            <input type="file" name="file" class="form-control" required>
                            <small class="form-text text-muted">Max size: 10MB. Allowed types: jpg, png, mp4, pdf, docx.</small>
                        </div>
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
                        <button type="submit" class="btn btn-primary">Upload Evidence</button>
                    </div>
                </div>
            </form>
        </div>
    </div>
</div>
@endsection