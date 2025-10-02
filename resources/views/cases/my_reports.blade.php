@extends('layouts.app')
@section('title', 'My Reported Cases')

@section('content')
<div class="container py-4">
    <div class="d-flex justify-content-between align-items-center mb-4">
        <h2 class="fw-bold">📑 My Reported Cases</h2>
        <button type="button" class="btn btn-primary" data-bs-toggle="modal" data-bs-target="#reportCaseModal">
            + Report New Case
        </button>
    </div>

    <!-- Cases List -->
    @if($cases->isEmpty())
        <div class="alert alert-info text-center">
            You have not reported any cases yet.
        </div>
    @else
        <div class="card shadow-sm border-0 rounded-4">
            <div class="card-body">
                <div class="table-responsive">
                    <table class="table align-middle">
                        <thead class="table-light">
                            <tr>
                                <th>Case #</th>
                                <th>Survivor</th>
                                <th>Type</th>
                                <th>Status</th>
                                <th>Date</th>
                                <th>Description</th>
                                <th></th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach($cases as $case)
                            <tr>
                                <td><strong>{{ $case->case_number }}</strong></td>
                                <td>{{ $case->survivor_name }}</td>
                                <td>
                                    <span class="badge bg-info text-dark text-capitalize">{{ $case->type }}</span>
                                </td>
                                <td>
                                    @if($case->status == 'pending')
                                        <span class="badge bg-warning text-dark">Pending</span>
                                    @elseif($case->status == 'resolved')
                                        <span class="badge bg-success">Resolved</span>
                                    @else
                                        <span class="badge bg-secondary">{{ ucfirst($case->status) }}</span>
                                    @endif
                                </td>
                                <td>{{ $case->created_at->format('M d, Y') }}</td>
                                <td>{{ Str::limit($case->description, 50) }}</td>
                                <td>
                                    <a href="{{ route('user.reportCases.show', $case->id) }}" class="btn btn-sm btn-outline-primary">
                                        View
                                    </a>
                                </td>
                            </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    @endif
</div>

<!-- Report Case Modal -->
<div class="modal fade" id="reportCaseModal" tabindex="-1" aria-labelledby="reportCaseModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-lg modal-dialog-centered">
        <div class="modal-content rounded-4 shadow-lg">
            <div class="modal-header bg-primary text-white">
                <h5 class="modal-title" id="reportCaseModalLabel">Report a Case</h5>
                <button type="button" class="btn-close btn-close-white" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>

            <form id="reportCaseForm" action="{{ route('user.reportCases.store') }}" method="POST" enctype="multipart/form-data">
                @csrf
                <div class="modal-body">
                    <div class="row g-3">
                        <!-- Email -->
                        <div class="col-md-6">
                            <label for="email" class="form-label">Your Email</label>
                            <input type="email" class="form-control" id="email" name="email" placeholder="example@mail.com" required>
                        </div>

                        <!-- Survivor Name -->
                        <div class="col-md-6">
                            <label for="survivorName" class="form-label">Name of Survivor</label>
                            <input type="text" class="form-control" id="survivorName" name="survivor_name" placeholder="Enter survivor's name" required>
                        </div>

                        <!-- Phone -->
                        <div class="col-md-6">
                            <label for="phone" class="form-label">Phone Number</label>
                            <input type="tel" class="form-control" id="phone" name="phone" placeholder="e.g. 078xxxxxxx" required>
                        </div>

                        <!-- Type of GBV -->
                        <div class="col-md-6">
                            <label for="type" class="form-label">Type of GBV</label>
                            <select class="form-select" id="type" name="type" required>
                                <option value="" selected disabled>Select type</option>
                                <option value="physical">Physical</option>
                                <option value="sexual">Sexual</option>
                                <option value="psychological">Psychological</option>
                            </select>
                        </div>

                        <!-- Description -->
                        <div class="col-12">
                            <label for="description" class="form-label">Description of Incident</label>
                            <textarea class="form-control" id="description" name="description" rows="4" placeholder="Describe what happened..." required></textarea>
                        </div>

                        <!-- Location -->
                        <div class="col-12">
                            <label for="location" class="form-label">Location (Optional)</label>
                            <input type="text" class="form-control" id="location" name="location" placeholder="Enter location">
                        </div>
                    </div>
                </div>

                <div class="modal-footer border-0">
                    <button type="button" class="btn btn-light" data-bs-dismiss="modal">Cancel</button>
                    <button type="submit" class="btn btn-primary">Submit Case</button>
                </div>
            </form>
        </div>
    </div>
</div>
@endsection
