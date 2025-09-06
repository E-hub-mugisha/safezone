@extends('layouts.app')
@section('title', 'My Reported Cases')
@section('content')
<h1>My Reported Cases</h1>
<p>List of cases you have reported:</p>
<hr>
<div class="mb-3">
    <button type="button" class="btn btn-primary" data-bs-toggle="modal" data-bs-target="#reportCaseModal">
        Add New Case
    </button>
    <!-- Report Case Modal -->
    <div class="modal fade" id="reportCaseModal" tabindex="-1" aria-labelledby="reportCaseModalLabel" aria-hidden="true">
        <div class="modal-dialog modal-lg">
            <div class="modal-content">

                <div class="modal-header">
                    <h5 class="modal-title" id="reportCaseModalLabel">Report a Case</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>

                <div class="modal-body">
                    <form id="reportCaseForm" action="{{ route('user.reportCases.store') }}" method="POST" enctype="multipart/form-data">
                        @csrf
                        <!-- email -->
                        <div class="mb-3">
                            <label for="email" class="form-label">Your Email</label>
                            <input type="email" class="form-control" id="email" name="email" placeholder="Enter your email" required>
                        </div>

                        <!-- Name of Survivor -->
                        <div class="mb-3">
                            <label for="survivorName" class="form-label">Name of Survivor</label>
                            <input type="text" class="form-control" id="survivorName" name="survivor_name" placeholder="Enter name of survivor" required>
                        </div>

                        <!-- phone -->
                        <div class="mb-3">
                            <label for="phone" class="form-label">Phone Number</label>
                            <input type="tel" class="form-control" id="phone" name="phone" placeholder="Enter phone number" required>
                        </div>

                        <!-- Type of GBV -->
                        <div class="mb-3">
                            <label for="type" class="form-label">Type of GBV</label>
                            <select class="form-select" id="type" name="type" required>
                                <option value="" selected disabled>Select type</option>
                                <option value="physical">Physical</option>
                                <option value="sexual">Sexual</option>
                                <option value="psychological">Psychological</option>
                            </select>
                        </div>

                        <!-- Description -->
                        <div class="mb-3">
                            <label for="description" class="form-label">Description of Incident</label>
                            <textarea class="form-control" id="description" name="description" rows="4" required></textarea>
                        </div>

                        <!-- Location -->
                        <div class="mb-3">
                            <label for="location" class="form-label">Location (Optional)</label>
                            <input type="text" class="form-control" id="location" name="location" placeholder="Enter location">
                        </div>

                    </form>
                </div>

                <div class="modal-footer">
                    <button type="button" class="btn btn-light" data-bs-dismiss="modal">Close</button>
                    <button type="submit" form="reportCaseForm" class="btn btn-primary">Submit Case</button>
                </div>
            </div>
        </div>
    </div>
</div>
@if($cases->isEmpty())
<p>No cases reported by you.</p>
@else
<ul>
    @foreach($cases as $case)
    <li>
        <a href="{{ route('safe_zone_cases.show', $case->id) }}">
            {{ $case->description }}
        </a>
    </li>
    @endforeach
</ul>
@endif
@endsection