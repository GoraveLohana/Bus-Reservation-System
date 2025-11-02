<?php
include("../db/connect.php");

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $bus_number = $_POST['bus_number'];
    $bus_name = $_POST['bus_name'];
    $total_seats = $_POST['total_seats'];
    $type = $_POST['type'];
    
    if (empty(trim($bus_number)) || empty(trim($bus_name)) || empty(trim($total_seats)) || empty(trim($type))) {
        echo "Please fill in all fields";
    } else {
        try {
            $sql = "INSERT INTO buses (bus_number, bus_name, total_seats, type) VALUES ('$bus_number', '$bus_name', '$total_seats', '$type')";
            
            if ($conn->query($sql) === TRUE) {
                header("Location: view_buses.php");
                exit();
            } else {
                echo "Error adding bus: " . $conn->error;
            }
        } catch (mysqli_sql_exception $e) {
            echo "Bus with this number already exists!";
        }
    }
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Add Bus - Bus Reservation System</title>
    <link rel="stylesheet" href="../style.css">
</head>
<body>
    <header>
        <h1>Bus Reservation System</h1>
    </header>

    <nav>
        <ul>
            <li><a href="../index.php">Home</a></li>
            <li><a href="view_buses.php">Buses</a></li>
            <li><a href="../routes/view_routes.php">Routes</a></li>
            <li><a href="../schedules/view_schedules.php">Schedules</a></li>
            <li><a href="../bookings/view_bookings.php">Bookings</a></li>
            <li><a href="../search.php">Search</a></li>
        </ul>
    </nav>

    <div class="container">
        <div class="card">
            <h2>Add New Bus</h2>
            <form method="POST">
                <div class="form-group">
                    <label for="bus_number">Bus Number :</label>
                    <input type="text" id="bus_number" name="bus_number" required>
                </div>
                
                <div class="form-group">
                    <label for="bus_name">Bus Name:</label>
                    <input type="text" id="bus_name" name="bus_name" required>
                </div>
                
                <div class="form-group">
                    <label for="total_seats">Total Seats:</label>
                    <input type="number" id="total_seats" name="total_seats" min="10" required>
                </div>
                
                <div class="form-group">
                    <label for="type">Bus Type:</label>
                    <select id="type" name="type" required>
                        <option value="">Select Type</option>
                        <option value="AC">AC</option>
                        <option value="Non-AC">Non-AC</option>
                        <option value="Sleeper">Sleeper</option>
                        <option value="Semi-Sleeper">Semi-Sleeper</option>
                    </select>
                </div>
                
                <input type="submit" value="Add Bus">
                <a href="view_buses.php" style="text-decoration: none; padding: 10px 20px; background-color: #95a5a6; color: white; border-radius: 4px;">Cancel</a>
            </form>
        </div>
    </div>
</body>
</html>
