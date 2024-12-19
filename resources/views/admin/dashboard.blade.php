@extends('admin.layouts.app')

@section('content')
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Admin Dashboard</title>
    <link rel="stylesheet" href="{{ asset('css/app.css') }}">
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0-beta3/css/all.min.css">
    <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>

    <style>
        body {
            background-color: #f8f9fa; /* Light background color */
            font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif;
        }

        .dashboard-container {
            margin: 30px auto;
            max-width: 1200px;
        }

        .card-header {
            background-color: #f44336; /* Lively Red */
            color: white;
            font-weight: bold;
            text-align: center;
            padding: 15px;
            border-radius: 8px 8px 0 0;
        }

        .card-body {
            padding: 20px;
        }

        .card {
            border: none;
            box-shadow: 0 4px 12px rgba(0, 0, 0, 0.1);
            border-radius: 8px;
            margin-top: 20px;
            background-color: #ffffff; /* White background for cards */
        }

        footer {
            padding: 15px;
            background-color: #f44336; /* Lively Red */
            color: white;
            text-align: center;
            margin-top: 30px;
        }

        .table th, .table td {
            vertical-align: middle;
        }

        .chart-container {
            padding: 20px;
            box-shadow: 0 4px 12px rgba(0, 0, 0, 0.1);
            background-color: #ffffff;
            border-radius: 10px;
            margin-top: 20px;
        }

        .card-header h5 {
            font-size: 1.2rem;
            margin: 0;
        }

        .graph-icon {
            font-size: 1.5rem;
            color: #ffffff;
            display: block;
            text-align: center;
            margin: 15px 0;
        }

        .chart-container {
            background-color: #f1f1f1;
            border-radius: 12px;
            padding: 30px;
        }
        
        /* Vivid Green for buttons */
        .btn-vivid {
            background-color: #4caf50; /* Green */
            color: white;
            border: none;
        }

        .btn-vivid:hover {
            background-color: #388e3c; /* Darker Green */
        }

        /* Bright Yellow for active elements */
        .btn-active {
            background-color: #ffeb3b; /* Bright Yellow */
            color: black;
            border: none;
        }

        .btn-active:hover {
            background-color: #fbc02d; /* Darker Yellow */
        }

        /* Vivid Blue for hover effects */
        .btn-vivid:hover {
            background-color: #1e88e5; /* Vivid Blue */
        }
        
    </style>
</head>

<body>
    <div class="dashboard-container">
        <h4 class="font-weight-bold text-xl mb-4 text-center" style="color: #f44336;">Sales Report</h4>

        <!-- Most Sold Product and Most Favorite Product -->
        <div class="row">
            <div class="col-md-6">
                <div class="card">
                    <div class="card-header">
                        <h5>Most Sold Product</h5>
                    </div>
                    <div class="card-body">
                        @if($mostSoldProduct)
                            <h6>Product Name: {{ $mostSoldProduct->name }}</h6>
                            <p><strong>Total Quantity Sold: </strong>{{ $mostSoldProduct->order_items_sum_quantity }}</p>
                            <p><strong>Price: </strong>₱{{ number_format($mostSoldProduct->price, 2) }}</p>
                        @else
                            <p>No products sold yet.</p>
                        @endif
                    </div>
                </div>
            </div>

            <div class="col-md-6">
                <div class="card">
                    <div class="card-header">
                        <h5>Most Favorite Product</h5>
                    </div>
                    <div class="card-body">
                        @if($mostFavoriteProduct)
                            <h6>Product Name: {{ $mostFavoriteProduct->name }}</h6>
                            <p><strong>Total Favorites: </strong>{{ $mostFavoriteProduct->favorited_by_count }}</p>
                            <p><strong>Price: </strong>₱{{ number_format($mostFavoriteProduct->price, 2) }}</p>
                        @else
                            <p>No products marked as favorite yet.</p>
                        @endif
                    </div>
                </div>
            </div>
        </div>

        <!-- Charts Section -->
        <div class="row">
            <!-- Most Sold Product Chart (Bar Chart) -->
            <div class="col-md-6">
                <div class="card">
                    <div class="card-header">
                        <h5>Most Sold Products Chart</h5>
                    </div>
                    <div class="card-body chart-container">
                        <canvas id="soldChart"></canvas>
                    </div>
                </div>
            </div>

            <!-- Most Favorite Product Chart (Pie Chart) -->
            <div class="col-md-6">
                <div class="card">
                    <div class="card-header">
                        <h5>Most Favorite Products Chart</h5>
                    </div>
                    <div class="card-body chart-container">
                        <canvas id="favoriteChart"></canvas>
                    </div>
                </div>
            </div>
        </div>

    </div>

    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@4.5.2/dist/js/bootstrap.bundle.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
    <script>
        // Most Sold Product Chart (Bar Chart)
        var soldChartCtx = document.getElementById('soldChart').getContext('2d');
        var soldChart = new Chart(soldChartCtx, {
            type: 'bar',
            data: {
                labels: @json($orderedProducts->pluck('name')), 
                datasets: [{
                    label: 'Quantity Sold',
                    data: @json($orderedProducts->pluck('order_items_sum_quantity')),
                    backgroundColor: 'rgba(66, 133, 244, 0.6)', // Bright Blue
                    borderColor: 'rgba(66, 133, 244, 1)', 
                    borderWidth: 1
                }]
            },
            options: {
                responsive: true,
                plugins: {
                    tooltip: {
                        backgroundColor: 'rgba(0, 0, 0, 0.7)',
                        bodyColor: 'white',
                        titleColor: 'white'
                    }
                },
                scales: {
                    y: {
                        beginAtZero: true
                    }
                }
            }
        });

        // Most Favorite Product Chart (Pie Chart)
        var favoriteChartCtx = document.getElementById('favoriteChart').getContext('2d');
        var favoriteChart = new Chart(favoriteChartCtx, {
            type: 'pie',
            data: {
                labels: @json($favoriteProducts->pluck('name')),
                datasets: [{
                    label: 'Number of Favorites',
                    data: @json($favoriteProducts->pluck('favorited_by_count')),
                    backgroundColor: [
                        'rgba(255, 159, 64, 0.6)',
                        'rgba(75, 192, 192, 0.6)',
                        'rgba(153, 102, 255, 0.6)',
                        'rgba(255, 99, 132, 0.6)',
                        'rgba(54, 162, 235, 0.6)'
                    ],
                    borderColor: [
                        'rgba(255, 159, 64, 1)',
                        'rgba(75, 192, 192, 1)',
                        'rgba(153, 102, 255, 1)',
                        'rgba(255, 99, 132, 1)',
                        'rgba(54, 162, 235, 1)'
                    ],
                    borderWidth: 1
                }]
            },
            options: {
                responsive: true,
                plugins: {
                    tooltip: {
                        backgroundColor: 'rgba(0, 0, 0, 0.7)',
                        bodyColor: 'white',
                        titleColor: 'white'
                    }
                }
            }
        });
    </script>
</body>

</html>
@endsection
