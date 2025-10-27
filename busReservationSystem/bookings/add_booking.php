<?php
include("../db/connect.php");

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $schedule_id = $_POST['schedule_id'];
    $customer_name = $_POST['customer_name'];
    $email = $_POST['email'];
    $seat_no = $_POST['seat_no'];
    
    if (empty(trim($schedule_id)) || empty(trim($customer_name)) || empty(trim($email)) || empty(trim($seat_no))) {
        echo "Please fill in all fields";
    } else {
        $seat_sql = "SELECT b.total_seats FROM schedule s, buses b WHERE s.bus_id = b.bus_id AND s.schedule_id = '$schedule_id'";
        $seat_result = $conn->query($seat_sql);
        
        if ($seat_result->num_rows > 0) {
            $row = $seat_result->fetch_assoc();
            $total_seats = $row['total_seats'];
            
            if ($seat_no >= 1 && $seat_no <= $total_seats) {
                $sql = "INSERT INTO bookings (schedule_id, customer_name, email, seat_no) VALUES ('$schedule_id', '$customer_name', '$email', '$seat_no')";
                
                if ($conn->query($sql) === TRUE) {
                    header("Location: view_bookings.php");
                    exit();
                } else {
                    echo "Error adding booking: " . $conn->error;
                }
            } else {
                echo "Invalid seat number! Please select a seat between 1 and " . $total_seats;
            }
        } else {
            echo "Invalid schedule selected!";
        }
    }
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Add Booking - Bus Reservation System</title>
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
            <li><a href="../schedules/view_schedules.php">Schedules</a></li>
            <li><a href="view_bookings.php">Bookings</a></li>
            <li><a href="../search.php">Search</a></li>
        </ul>
    </nav>

    <div class="container">
        <div class="card">
            <h2>Add New Booking</h2>
            <form method="POST">
                <div class="form-group">
                    <label for="schedule_id">Select Schedule:</label>
                    <select id="schedule_id" name="schedule_id" required>
                        <option value="">Select Schedule</option>
                        <?php
                        $sql = "SELECT s.*, b.bus_name, b.bus_number, r.source, r.destination 
                                FROM schedule s 
                                JOIN buses b ON s.bus_id = b.bus_id 
                                JOIN routes r ON s.route_id = r.route_id";
                        $result = $conn->query($sql);
                        if ($result->num_rows > 0) {
                            while($row = $result->fetch_assoc()) {
                                echo "<option value='" . $row["schedule_id"] . "'>";
                                echo $row["bus_name"] . " (" . $row["bus_number"] . ") - ";
                                echo $row["source"] . " to " . $row["destination"] . " - ";
                                echo date('Y-m-d H:i', strtotime($row["departure_time"])) . " - ";
                                echo "PKR " . $row["fare"];
                                echo "</option>";
                            }
                        }
                        ?>
                    </select>
                </div>
                
                <div class="form-group">
                    <label for="customer_name">Customer Name:</label>
                    <input type="text" id="customer_name" name="customer_name" required>
                </div>
                
                <div class="form-group">
                    <label for="email">Email:</label>
                    <input type="email" id="email" name="email" required>
                </div>
                
                <div class="form-group">
                    <label for="seat_no">Seat Number:</label>
                    <input type="number" id="seat_no" name="seat_no" required>
                </div>
                
                <input type="submit" value="Add Booking">
                <a href="view_bookings.php" style="text-decoration: none; padding: 10px 20px; background-color: #95a5a6; color: white; border-radius: 4px;">Cancel</a>
            </form>
        </div>
    </div>
</body>
</html>
