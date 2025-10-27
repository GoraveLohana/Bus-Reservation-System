<?php
include("db/connect.php");
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Bus Reservation System</title>
    <link rel="stylesheet" href="style.css">
</head>
<body>
    <header>
        <h1>Bus Reservation System</h1>
    </header>

    <nav>
        <ul>
            <li><a href="index.php">Home</a></li>
            <li><a href="buses/view_buses.php">Buses</a></li>
            <li><a href="routes/view_routes.php">Routes</a></li>
            <li><a href="schedules/view_schedules.php">Schedules</a></li>
            <li><a href="bookings/view_bookings.php">Bookings</a></li>
            <li><a href="search.php">Search</a></li>
        </ul>
    </nav>

    <div class="container">
        <div class="card">
            <h2>Welcome to Bus Reservation System</h2>
            <p>Manage your bus operations efficiently with our comprehensive reservation system.</p>
            
            <div style="display: grid; grid-template-columns: repeat(auto-fit, minmax(250px, 1fr)); gap: 20px; margin-top: 30px;">
                <div class="card">
                    <h3>Buses</h3>
                    <p>Manage bus fleet information including bus numbers, names, seat capacity, and types.</p>
                    <a href="buses/view_buses.php" class="view-btn" style="display: inline-block; margin-top: 10px;">View Buses</a>
                </div>
                
                <div class="card">
                    <h3>Routes</h3>
                    <p>Configure bus routes with source, destination, distance, and duration details.</p>
                    <a href="routes/view_routes.php" class="view-btn" style="display: inline-block; margin-top: 10px;">View Routes</a>
                </div>
                
                <div class="card">
                    <h3>Schedules</h3>
                    <p>Set up bus schedules with departure times, arrival times, and fare information.</p>
                    <a href="schedules/view_schedules.php" class="view-btn" style="display: inline-block; margin-top: 10px;">View Schedules</a>
                </div>
                
                <div class="card">
                    <h3>Bookings</h3>
                    <p>Handle customer bookings and manage seat reservations.</p>
                    <a href="bookings/view_bookings.php" class="view-btn" style="display: inline-block; margin-top: 10px;">View Bookings</a>
                </div>
            </div>
        </div>
    </div>
</body>
</html>
