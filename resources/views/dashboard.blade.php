<!DOCTYPE html>
<html>
<head>
    <title>Monitoring Smart Irrigation System</title>
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css">
    <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
    <style>
        body {
            position: relative;
            margin: 0;
            padding: 0;
            color: #fff;
            background-color: #f8f9fa;
        }

        body::before {
            content: "";
            position: absolute;
            top: 0;
            left: 0;
            width: 100%;
            height: 100%;
            background-image: url('{{ asset('assets/images/background.jpg') }}');
            background-size: cover;
            background-repeat: no-repeat;
            background-attachment: fixed;
            filter: blur(5px);
            z-index: -1;
        }

        #chartContainer {
            display: flex;
            justify-content: center;
            align-items: flex-start;
        }

        .chart {
            max-width: 500px;
            height: auto;
            margin: 20px;
            background-color: #fff;
            padding: 10px;
            border-radius: 10px;
            box-shadow: 0 0 10px rgba(0, 0, 0, 0.1);
        }

        #bottomChartsContainer {
            display: flex;
            justify-content: space-between;
            margin-top: 50px;
        }

        .container {
            position: relative;
            z-index: 1;
        }

        .navbar {
            position: relative;
            z-index: 1;
        }

        .header {
            display: flex;
            align-items: center;
            justify-content: center;
            text-align: center;
        }
        
        .header img {
            margin-right: 10px;
        }

        .small-table {
            max-width: 400px;
            margin: 20px;
            margin-left: 40px; /* Tambahkan properti ini untuk menggeser tabel ke kanan */
            background-color: #;
            border-radius: 5px;
            box-shadow: 0 0 10px rgba(0, 0, 0, 0.1);
            overflow: hidden; /* Untuk menghindari masalah border-radius */
        }

        .small-table table {
            width: 100%;
            border-collapse: collapse; /* Agar border tidak berjarak */
        }

        .small-table th, .small-table td {
            padding: 10px;
            text-align: center;
            border-bottom: 10px; /* Garis batas bawah */
        }

        .small-table thead {
            background-color: #8FBC8F; /* Warna latar belakang kepala tabel */
            color: #; /* Warna teks kepala tabel */
        }

        .small-table tbody tr:nth-child(odd) {
            background-color: #F0FFF0; /* Warna latar belakang baris ganjil */
        }

        .small-table tbody tr:nth-child(even) {
            background-color: #F0FFF0; /* Warna latar belakang baris genap */
        }

        .small-table tbody tr:hover {
            background-color: #F0FFF0; /* Warna latar belakang baris saat hover */
        }

        .small-table .table-info {
            background-color: #F0FFF0; /* Warna latar belakang baris informasi */
            color: ; /* Warna teks baris informasi */
        }
    </style>
</head>
<body>
    <!-- Navbar -->
    <nav class="navbar navbar-expand-lg navbar-dark bg-dark">
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
        <div class="header">
            <img src="{{ asset('images/logo mosis.png') }}" alt="Image" width="640" height="170">
        </div>
        <div id="chartContainer">
            <!-- Canvas for Soil Moisture Chart -->
            <canvas id="soilMoistureChart" class="chart" width="300" height="90"></canvas>
            
            <!-- Tabel Keadaan Tanah Kecil -->
            <div class="small-table">
                <table class="table table-bordered table-striped">
                    <thead>
                        <tr>
                            <th>Jam</th>
                            <th>Kelembapan Tanah (%)</th>
                            <th>Suhu (°C)</th>
                            <th>Kelembapan Udara (%)</th>
                        </tr>
                    </thead>
                    <tbody>
                        <tr class="table-info">
                            <td>14.44</td>
                            <td>12</td>
                            <td>20</td>
                            <td>18</td>
                        </tr>
                    </tbody>
                </table>
            </div>
        </div>
        <div id="bottomChartsContainer">
            <!-- Canvas for Temperature Chart -->
            <canvas id="temperatureChart" class="chart" width="300" height="90"></canvas>
            <!-- Canvas for Humidity Chart -->
            <canvas id="suhuChart" class="chart" width="300" height="90"></canvas>
        </div>
    </div>

    <script>
        document.addEventListener('DOMContentLoaded', function () {
            var data = @json($data);

            function convertToLocalTime(utcTime) {
                var date = new Date(utcTime + 'Z');
                return date.toLocaleTimeString('id-ID', { hour: '2-digit', minute: '2-digit' });
            }

            var labels = data.map(item => convertToLocalTime(item.recorded_at));
            var soilMoistureData = data.map(item => item.moisture);
            var temperatureData = data.map(item => item.temperature);
            var humidityData = data.map(item => item.humidity);

            var ctx1 = document.getElementById('soilMoistureChart').getContext('2d');
            new Chart(ctx1, {
                type: 'line',
                data: {
                    labels: labels,
                    datasets: [{
                        label: 'Kelembapan Tanah (%)',
                        data: soilMoistureData,
                        borderColor: 'rgba(75, 192, 192, 1)',
                        backgroundColor: 'rgba(75, 192, 192, 0.2)',
                        borderWidth: 1,
                        fill: true
                    }]
                },
                options: {
                    scales: {
                        x: {
                            beginAtZero: true
                        },
                        y: {
                            beginAtZero: true
                        }
                    }
                }
            });

            var ctx2 = document.getElementById('temperatureChart').getContext('2d');
            new Chart(ctx2, {
                type: 'line',
                data: {
                    labels: labels,
                    datasets: [{
                        label: 'Suhu (°C)',
                        data: temperatureData,
                        borderColor: 'rgba(255, 99, 132, 1)',
                        backgroundColor: 'rgba(255, 99, 132, 0.2)',
                        borderWidth: 1,
                        fill: true
                    }]
                },
                options: {
                    scales: {
                        x: {
                            beginAtZero: true
                        },
                        y: {
                            beginAtZero: true,
                            ticks: {
                                callback: function(value, index, values) {
                                    return value + '°C';
                                }
                            }
                        }
                    }
                }
            });

            var ctx3 = document.getElementById('suhuChart').getContext('2d');
            new Chart(ctx3, {
                type: 'line',
                data: {
                    labels: labels,
                    datasets: [{
                        label: 'Kelembapan Udara (%)',
                        data: humidityData,
                        borderColor: 'rgba(54, 162, 235, 1)',
                        backgroundColor: 'rgba(54, 162, 235, 0.2)',
                        borderWidth: 1,
                        fill: true
                    }]
                },
                options: {
                    scales: {
                        x: {
                            beginAtZero: true
                        },
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