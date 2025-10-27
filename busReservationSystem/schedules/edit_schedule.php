<?php
include("../db/connect.php");

$schedule_id = $_GET['id'];
$bus_id = "";
$route_id = "";
$departure_time = "";
$arrival_time = "";
$fare = "";

$sql = "SELECT * FROM schedule WHERE schedule_id = '$schedule_id'";
$result = $conn->query($sql);

if ($result->num_rows > 0) {
    $row = $result->fetch_assoc();
    $bus_id = $row["bus_id"];
    $route_id = $row["route_id"];
    $departure_time = date('Y-m-d\TH:i', strtotime($row["departure_time"]));
    $arrival_time = date('Y-m-d\TH:i', strtotime($row["arrival_time"]));
    $fare = $row["fare"];
}

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $bus_id = $_POST['bus_id'];
    $route_id = $_POST['route_id'];
    $departure_time = $_POST['departure_time'];
    $arrival_time = $_POST['arrival_time'];
    $fare = $_POST['fare'];
    
    if (empty($bus_id) || empty($route_id) || empty($departure_time) || empty($arrival_time) || empty($fare)) {
        echo "Please fill in all fields";
    } else {
        try {
            $sql = "UPDATE schedule SET bus_id='$bus_id', route_id='$route_id', departure_time='$departure_time', arrival_time='$arrival_time', fare='$fare' WHERE schedule_id='$schedule_id'";
            
            if ($conn->query($sql) === TRUE) {
                header("Location: view_schedules.php");
                exit();
            } else {
                echo "Error updating schedule: " . $conn->error;
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
    <title>Edit Schedule - Bus Reservation System</title>
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
            <h2>Edit Schedule</h2>
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
                                $selected = ($row["bus_id"] == $bus_id) ? "selected" : "";
                                echo "<option value='" . $row["bus_id"] . "' $selected>" . $row["bus_name"] . " (" . $row["bus_number"] . ")</option>";
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
                                $selected = ($row["route_id"] == $route_id) ? "selected" : "";
                                echo "<option value='" . $row["route_id"] . "' $selected>" . $row["source"] . " to " . $row["destination"] . "</option>";
                            }
                        }
                        ?>
                    </select>
                </div>
                
                <div class="form-group">
                    <label for="departure_time">Departure Time:</label>
                    <input type="datetime-local" id="departure_time" name="departure_time" value="<?php echo $departure_time; ?>" required>
                </div>
                
                <div class="form-group">
                    <label for="arrival_time">Arrival Time:</label>
                    <input type="datetime-local" id="arrival_time" name="arrival_time" value="<?php echo $arrival_time; ?>" required>
                </div>
                
                <div class="form-group">
                    <label for="fare">Fare ($):</label>
                    <input type="number" id="fare" name="fare" value="<?php echo $fare; ?>" step="0.01" required>
                </div>
                
                <input type="submit" value="Update Schedule">
                <a href="view_schedules.php" style="text-decoration: none; padding: 10px 20px; background-color: #95a5a6; color: white; border-radius: 4px;">Cancel</a>
            </form>
        </div>
    </div>
</body>
</html>

