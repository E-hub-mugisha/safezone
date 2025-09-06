@extends('layouts.app')
@section('title', 'Admin Dashboard')

@section('content')
<div class="container">
    <h2 class="mb-4">Admin Dashboard - Case Analytics</h2>
<!-- Stats Cards -->
    <div class="row g-4 mb-4">
        <div class="col-md-3">
            <div class="card text-white bg-primary shadow-sm h-100">
                <div class="card-body d-flex align-items-center">
                    <i class="bi bi-folder2-open fs-1 me-3"></i>
                    <div>
                        <h5 class="card-title">Total Cases</h5>
                        <h3>{{ $totalCases ?? 0 }}</h3>
                    </div>
                </div>
            </div>
        </div>

        <div class="col-md-3">
            <div class="card text-white bg-success shadow-sm h-100">
                <div class="card-body d-flex align-items-center">
                    <i class="bi bi-people fs-1 me-3"></i>
                    <div>
                        <h5 class="card-title">Users</h5>
                        <h3>{{ $totalUsers ?? 0 }}</h3>
                    </div>
                </div>
            </div>
        </div>

        <div class="col-md-3">
            <div class="card text-white bg-warning shadow-sm h-100">
                <div class="card-body d-flex align-items-center">
                    <i class="bi bi-person-badge fs-1 me-3"></i>
                    <div>
                        <h5 class="card-title">Staff</h5>
                        <h3>{{ $totalStaff ?? 0 }}</h3>
                    </div>
                </div>
            </div>
        </div>

        <div class="col-md-3">
            <div class="card text-white bg-info shadow-sm h-100">
                <div class="card-body d-flex align-items-center">
                    <i class="bi bi-folder2 fs-1 me-3"></i>
                    <div>
                        <h5 class="card-title">Evidences</h5>
                        <h3>{{ $totalEvidences ?? 0 }}</h3>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <div class="row">
        <!-- Cases by Type -->
        <div class="col-md-4">
            <div class="card p-3 shadow">
                <h5 class="text-center">Cases by Type</h5>
                <canvas id="casesByType"></canvas>
            </div>
        </div>

        <!-- Cases by Status -->
        <div class="col-md-4">
            <div class="card p-3 shadow">
                <h5 class="text-center">Cases by Status</h5>
                <canvas id="casesByStatus"></canvas>
            </div>
        </div>

        <!-- Cases by Location -->
        <div class="col-md-4">
            <div class="card p-3 shadow">
                <h5 class="text-center">Top Locations</h5>
                <canvas id="casesByLocation"></canvas>
            </div>
        </div>
    </div>
    <!-- Recent Cases Table -->
    <div class="card shadow-sm mb-4 mt-4">
        <div class="card-header bg-secondary text-white">
            <i class="bi bi-folder2-open me-2"></i> Recent Cases
        </div>
        <div class="card-body">
            @if($recentCases->count() > 0)
            <div class="table-responsive">
                <table class="table table-striped table-bordered">
                    <thead>
                        <tr>
                            <th>Case #</th>
                            <th>Type</th>
                            <th>Status</th>
                            <th>Reported By</th>
                            <th>Assigned Agent</th>
                            <th>Assigned Medical</th>
                            <th>Actions</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach($recentCases as $case)
                        <tr>
                            <td>{{ $case->case_number }}</td>
                            <td>{{ ucfirst($case->type) }}</td>
                            <td>
                                <span class="badge 
                                    @if($case->status=='pending') bg-warning
                                    @elseif($case->status=='verified') bg-info
                                    @elseif($case->status=='in_progress') bg-primary
                                    @elseif($case->status=='resolved') bg-success
                                    @endif">
                                    {{ ucfirst(str_replace('_',' ',$case->status)) }}
                                </span>
                            </td>
                            <td>{{ $case->survivor_name }}</td>
                            <td>{{ $case->agent->name ?? 'Not Assigned' }}</td>
                            <td>{{ $case->medical->name ?? 'Not Assigned' }}</td>
                            <td>
                                <a href="{{ route('safe-zone-cases.show', $case->id) }}" class="btn btn-sm btn-primary">
                                    <i class="bi bi-eye"></i> View
                                </a>
                            </td>
                        </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>
            @else
            <p class="text-muted">No recent cases available.</p>
            @endif
        </div>
    </div>
</div>

<!-- Chart.js -->
<script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
<script>
document.addEventListener("DOMContentLoaded", function () {
    // Cases by Type
    new Chart(document.getElementById('casesByType'), {
        type: 'pie',
        data: {
            labels: {!! json_encode($casesByType->keys()) !!},
            datasets: [{
                data: {!! json_encode($casesByType->values()) !!},
                backgroundColor: ['#ff6384','#36a2eb','#ffce56']
            }]
        }
    });

    // Cases by Status
    new Chart(document.getElementById('casesByStatus'), {
        type: 'doughnut',
        data: {
            labels: {!! json_encode($casesByStatus->keys()) !!},
            datasets: [{
                data: {!! json_encode($casesByStatus->values()) !!},
                backgroundColor: ['#ffc107','#17a2b8','#28a745','#dc3545']
            }]
        }
    });

    // Cases by Location
    new Chart(document.getElementById('casesByLocation'), {
        type: 'bar',
        data: {
            labels: {!! json_encode($casesByLocation->keys()) !!},
            datasets: [{
                label: 'Cases',
                data: {!! json_encode($casesByLocation->values()) !!},
                backgroundColor: '#007bff'
            }]
        },
        options: {
            scales: { y: { beginAtZero: true } }
        }
    });
});
</script>
@endsection
