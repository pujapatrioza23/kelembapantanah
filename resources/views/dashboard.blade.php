<!DOCTYPE html>
<html>
<head>
    <title>Monitoring Smart Irrigation System</title>
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css">
    <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
    <style>
        body {
            background-color: #ffff; /* Warna latar belakang biru muda */
        }

        #chartContainer {
            display: flex;
            justify-content: space-between;
            align-items: flex-start;
        }

        .chart {
            max-width: 500px;
            height: auto;
            margin-right: 50px;
        }

        #suhuChartContainer {
            display: relative;
            justify-content: center;
            margin-top: 50px;
        }
    </style>
</head>
<body>
    <!-- Navbar -->
    <nav class="navbar navbar-expand-lg navbar-dark bg-primary">
        <a class="navbar-brand" href="#">Dashboard</a>
        <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#navbarNav" aria-controls="navbarNav" aria-expanded="false" aria-label="Toggle navigation">
            <span class="navbar-toggler-icon"></span>
        </button>
        <div class="collapse navbar-collapse" id="navbarNav">
            <ul class="navbar-nav">
                <li class="nav-item active">
            </ul>
        </div>
    </nav>
    <div class="container mt-5">
        <h1>Monitoring Smart Irrigation System</h1>
        <div id="chartContainer">
            <!-- Canvas for Soil Moisture Chart -->
            <canvas id="soilMoistureChart" class="chart" width="300" height="90"></canvas>
            <!-- Canvas for Temperature Chart -->
            <canvas id="temperatureChart" class="chart" width="300" height="90"></canvas>
        </div>
        <div id="suhuChartContainer">
            <!-- Canvas for Humidity Chart -->
            <canvas id="suhuChart" class="chart" width="800" height="200"></canvas>
        </div>
    </div>

    <script>
        document.addEventListener('DOMContentLoaded', function () {
            // Data dari controller
            var data = @json($data);

            // Format data untuk Chart.js
            var labels = data.map(item => item.recorded_at);
            var soilMoistureData = data.map(item => item.moisture);
            var temperatureData = data.map(item => item.temperature);
            var humidityData = data.map(item => item.humidity);

            // Chart untuk Kelembapan Tanah
            var ctx1 = document.getElementById('soilMoistureChart').getContext('2d');
            new Chart(ctx1, {
                type: 'line',
                data: {
                    labels: labels,
                    datasets: [{
                        label: 'Kelembapan Tanah',
                        data: soilMoistureData,
                        borderColor: 'rgba(75, 192, 192, 1)',
                        backgroundColor: 'rgba(75, 192, 192, 0.2)',
                        borderWidth: 1,
                        fill: true
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

            // Chart untuk Suhu
            var ctx2 = document.getElementById('temperatureChart').getContext('2d');
            new Chart(ctx2, {
                type: 'line',
                data: {
                    labels: labels,
                    datasets: [{
                        label: 'Suhu',
                        data: temperatureData,
                        borderColor: 'rgba(255, 99, 132, 1)',
                        backgroundColor: 'rgba(255, 99, 132, 0.2)',
                        borderWidth: 1,
                        fill: true
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

            // Chart untuk Kelembapan Udara
            var ctx3 = document.getElementById('suhuChart').getContext('2d');
            new Chart(ctx3, {
                type: 'line',
                data: {
                    labels: labels,
                    datasets: [{
                        label: 'Kelembapan Udara',
                        data: humidityData,
                        borderColor: 'rgba(54, 162, 235, 1)',
                        backgroundColor: 'rgba(54, 162, 235, 0.2)',
                        borderWidth: 1,
                        fill: true
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
        });
    </script>
</body>
</html>
