@extends('layouts.app')
@section('title', 'Admin Dashboard')

@section('content')
<div class="container">
    <h2 class="mb-4">Admin Dashboard - Case Analytics</h2>

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
