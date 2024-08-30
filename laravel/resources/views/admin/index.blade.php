@extends('layouts.layouts')

@section('content')
<main id="main" class="main">

    <div class="pagetitle">
        <h1>Dashboard</h1>
        <nav>
            <ol class="breadcrumb">
                <li class="breadcrumb-item"><a href="index.html">Home</a></li>
                <li class="breadcrumb-item active">Dashboard</li>
            </ol>
        </nav>
    </div><!-- End Page Title -->

    <section class="section dashboard">
        <div class="row">

            <!-- Total Users Card -->
            <div class="col-lg-6">
                <div class="card info-card">
                    <div class="card-body">
                        <h5 class="card-title">Total Users</h5>
                        <div class="d-flex align-items-center">
                            <div class="ps-3">
                                <h6>{{ $totalUsers }}</h6>
                            </div>
                        </div>
                    </div>
                </div>
            </div><!-- End Total Users Card -->

            <!-- Total Predictions Card -->
            <div class="col-lg-6">
                <div class="card info-card">
                    <div class="card-body">
                        <h5 class="card-title">Total Predictions</h5>
                        <div class="d-flex align-items-center">
                            <div class="ps-3">
                                <h6>{{ $totalPredictions }}</h6>
                            </div>
                        </div>
                    </div>
                </div>
            </div><!-- End Total Predictions Card -->

            <!-- User Growth Chart -->
            <div class="col-lg-6">
                <div class="card">
                    <div class="card-body">
                        <h5 class="card-title">User Growth</h5>
                        <canvas id="userGrowthChart"></canvas>
                    </div>
                </div>
            </div><!-- End User Growth Chart -->

            <!-- Prediction Growth Chart -->
            <div class="col-lg-6">
                <div class="card">
                    <div class="card-body">
                        <h5 class="card-title">Prediction Growth</h5>
                        <canvas id="predictionGrowthChart"></canvas>
                    </div>
                </div>
            </div><!-- End Prediction Growth Chart -->

        </div>
    </section>

</main><!-- End #main -->
@endsection

@section('js')
<script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
<script>
    var months = @json($months->values());

    var userGrowthChart = new Chart(document.getElementById('userGrowthChart').getContext('2d'), {
        type: 'line',
        data: {
            labels: months,
            datasets: [{
                label: 'User Growth',
                data: @json($userChartData->values()),
                backgroundColor: 'rgba(54, 162, 235, 0.2)',
                borderColor: 'rgba(54, 162, 235, 1)',
                borderWidth: 1
            }]
        },
        options: {
            scales: {
                y: {
                    beginAtZero: true
                }
            }
        }
    });

    var predictionGrowthChart = new Chart(document.getElementById('predictionGrowthChart').getContext('2d'), {
        type: 'line',
        data: {
            labels: months,
            datasets: [{
                label: 'Prediction Growth',
                data: @json($predictionChartData->values()),
                backgroundColor: 'rgba(75, 192, 192, 0.2)',
                borderColor: 'rgba(75, 192, 192, 1)',
                borderWidth: 1
            }]
        },
        options: {
            scales: {
                y: {
                    beginAtZero: true
                }
            }
        }
    });
</script>
@endsection
