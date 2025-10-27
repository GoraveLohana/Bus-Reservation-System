<?php
include("../db/connect.php");

$route_id = $_GET['id'];
$source = "";
$destination = "";
$distance = "";
$duration = "";

$sql = "SELECT * FROM routes WHERE route_id = '$route_id'";
$result = $conn->query($sql);

if ($result->num_rows > 0) {
    $row = $result->fetch_assoc();
    $source = $row["source"];
    $destination = $row["destination"];
    $distance = $row["distance"];
    $duration = $row["duration"];
}

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $source = $_POST['source'];
    $destination = $_POST['destination'];
    $distance = $_POST['distance'];
    $duration = $_POST['duration'];
    
    if (empty($source) || empty($destination) || empty($distance) || empty($duration)) {
        echo "Please fill in all fields";
    } else {
        try {
            $sql = "UPDATE routes SET source='$source', destination='$destination', distance='$distance', duration='$duration' WHERE route_id='$route_id'";
            
            if ($conn->query($sql) === TRUE) {
                header("Location: view_routes.php");
                exit();
            } else {
                echo "Error updating route: " . $conn->error;
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
    <title>Edit Route - Bus Reservation System</title>
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
            <h2>Edit Route</h2>
            <form method="POST">
                <div class="form-group">
                    <label for="source">Source:</label>
                    <input type="text" id="source" name="source" value="<?php echo $source; ?>" required>
                </div>
                
                <div class="form-group">
                    <label for="destination">Destination:</label>
                    <input type="text" id="destination" name="destination" value="<?php echo $destination; ?>" required>
                </div>
                
                <div class="form-group">
                    <label for="distance">Distance (km):</label>
                    <input type="number" id="distance" name="distance" value="<?php echo $distance; ?>" required>
                </div>
                
                <div class="form-group">
                    <label for="duration">Duration:</label>
                    <input type="text" id="duration" name="duration" value="<?php echo $duration; ?>" placeholder="e.g., 2 hours 30 minutes" required>
                </div>
                
                <input type="submit" value="Update Route">
                <a href="view_routes.php" style="text-decoration: none; padding: 10px 20px; background-color: #95a5a6; color: white; border-radius: 4px;">Cancel</a>
            </form>
        </div>
    </div>
</body>
</html>
