<?php
include("../db/connect.php");

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $bus_id = $_POST['bus_id'];
    $route_id = $_POST['route_id'];
    $departure_time = $_POST['departure_time'];
    $arrival_time = $_POST['arrival_time'];
    $fare = $_POST['fare'];
    
    if (empty(trim($bus_id)) || empty(trim($route_id)) || empty(trim($departure_time)) || empty(trim($arrival_time)) || empty(trim($fare))) {
        echo "Please fill in all fields";
    } else {
        try {
            $sql = "INSERT INTO schedule (bus_id, route_id, departure_time, arrival_time, fare) VALUES ('$bus_id', '$route_id', '$departure_time', '$arrival_time', '$fare')";
            
            if ($conn->query($sql) === TRUE) {
                header("Location: view_schedules.php");
                exit();
            } else {
                echo "Error adding schedule: " . $conn->error;
            }
        } catch (mysqli_sql_exception $e) {
            echo "Schedule already exists!";
        }
    }
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Add Schedule - Bus Reservation System</title>
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
            <li><a href="../routes/view_routes.php">Routes</a></li>
            <li><a href="view_schedules.php">Schedules</a></li>
            <li><a href="../bookings/view_bookings.php">Bookings</a></li>
            <li><a href="../search.php">Search</a></li>
        </ul>
    </nav>

    <div class="container">
        <div class="card">
            <h2>Add New Schedule</h2>
            <form method="POST">
                <div class="form-group">
                    <label for="bus_id">Select Bus:</label>
                    <select id="bus_id" name="bus_id" required>
                        <option value="">Select Bus</option>
                        <?php
                        $sql = "SELECT * FROM buses";
                        $result = $conn->query($sql);
                        if ($result->num_rows > 0) {
                            while($row = $result->fetch_assoc()) {
                                echo "<option value='" . $row["bus_id"] . "'>" . $row["bus_name"] . " (" . $row["bus_number"] . ")</option>";
                            }
                        }
                        ?>
                    </select>
                </div>
                
                <div class="form-group">
                    <label for="route_id">Select Route:</label>
                    <select id="route_id" name="route_id" required>
                        <option value="">Select Route</option>
                        <?php
                        $sql = "SELECT * FROM routes";
                        $result = $conn->query($sql);
                        if ($result->num_rows > 0) {
                            while($row = $result->fetch_assoc()) {
                                echo "<option value='" . $row["route_id"] . "'>" . $row["source"] . " to " . $row["destination"] . "</option>";
                            }
                        }
                        ?>
                    </select>
                </div>
                
                <div class="form-group">
                    <label for="departure_time">Departure Time:</label>
                    <input type="datetime-local" id="departure_time" name="departure_time" required>
                </div>
                
                <div class="form-group">
                    <label for="arrival_time">Arrival Time:</label>
                    <input type="datetime-local" id="arrival_time" name="arrival_time" required>
                </div>
                
                <div class="form-group">
                    <label for="fare">Fare (PKR):</label>
                    <input type="number" id="fare" name="fare" step="0.01" required>
                </div>
                
                <input type="submit" value="Add Schedule">
                <a href="view_schedules.php" style="text-decoration: none; padding: 10px 20px; background-color: #95a5a6; color: white; border-radius: 4px;">Cancel</a>
            </form>
        </div>
    </div>
</body>
</html>
