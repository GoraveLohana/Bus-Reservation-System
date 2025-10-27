<?php
include("../db/connect.php");

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $source = $_POST['source'];
    $destination = $_POST['destination'];
    $distance = $_POST['distance'];
    $duration = $_POST['duration'];
    
    if (empty(trim($source)) || empty(trim($destination)) || empty(trim($distance)) || empty(trim($duration))) {
        echo "Please fill in all fields";
    } else {
        try {
            $sql = "INSERT INTO routes (source, destination, distance, duration) VALUES ('$source', '$destination', '$distance', '$duration')";
            
            if ($conn->query($sql) === TRUE) {
                header("Location: view_routes.php");
                exit();
            } else {
                echo "Error adding route: " . $conn->error;
            }
        } catch (mysqli_sql_exception $e) {
            echo "Route already exists!";
        }
    }
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Add Route - Bus Reservation System</title>
    <link rel="stylesheet" href="../style.css">
</head>
<body>
    <header>
        <h1>Bus Reservation System</h1>
    </header>

    <nav>
        <ul>
            <li><a href="../index.php">Home</a></li>
            <li><a href="../buses/view_buses.php">Buses</a></li>
            <li><a href="view_routes.php">Routes</a></li>
            <li><a href="../schedules/view_schedules.php">Schedules</a></li>
            <li><a href="../bookings/view_bookings.php">Bookings</a></li>
            <li><a href="../search.php">Search</a></li>
        </ul>
    </nav>

    <div class="container">
        <div class="card">
            <h2>Add New Route</h2>
            <form method="POST">
                <div class="form-group">
                    <label for="source">Source:</label>
                    <input type="text" id="source" name="source" required>
                </div>
                
                <div class="form-group">
                    <label for="destination">Destination:</label>
                    <input type="text" id="destination" name="destination" required>
                </div>
                
                <div class="form-group">
                    <label for="distance">Distance (km):</label>
                    <input type="number" id="distance" name="distance" required>
                </div>
                
                <div class="form-group">
                    <label for="duration">Duration:</label>
                    <input type="text" id="duration" name="duration" placeholder="e.g., 2 hours 30 minutes" required>
                </div>
                
                <input type="submit" value="Add Route">
                <a href="view_routes.php" style="text-decoration: none; padding: 10px 20px; background-color: #95a5a6; color: white; border-radius: 4px;">Cancel</a>
            </form>
        </div>
    </div>
</body>
</html>
