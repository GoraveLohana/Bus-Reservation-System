<?php
include("../db/connect.php");

$booking_id = $_GET['id'];
$schedule_id = "";
$customer_name = "";
$email = "";
$seat_no = "";

$sql = "SELECT * FROM bookings WHERE booking_id = '$booking_id'";
$result = $conn->query($sql);

if ($result->num_rows > 0) {
    $row = $result->fetch_assoc();
    $schedule_id = $row["schedule_id"];
    $customer_name = $row["customer_name"];
    $email = $row["email"];
    $seat_no = $row["seat_no"];
}

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $schedule_id = $_POST['schedule_id'];
    $customer_name = $_POST['customer_name'];
    $email = $_POST['email'];
    $seat_no = $_POST['seat_no'];
    
    if (empty($schedule_id) || empty($customer_name) || empty($email) || empty($seat_no)) {
        echo "Please fill in all fields";
    } else {
        try {
            $sql = "UPDATE bookings SET schedule_id='$schedule_id', customer_name='$customer_name', email='$email', seat_no='$seat_no' WHERE booking_id='$booking_id'";
            
            if ($conn->query($sql) === TRUE) {
                header("Location: view_bookings.php");
                exit();
            } else {
                echo "Error updating booking: " . $conn->error;
            }
        } catch (mysqli_sql_exception $e) {
            echo "Seat already booked or customer with this email already has a booking!";
        }
    }
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Edit Booking - Bus Reservation System</title>
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
            <h2>Edit Booking</h2>
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
                                $selected = ($row["schedule_id"] == $schedule_id) ? "selected" : "";
                                echo "<option value='" . $row["schedule_id"] . "' $selected>";
                                echo $row["bus_name"] . " (" . $row["bus_number"] . ") - ";
                                echo $row["source"] . " to " . $row["destination"] . " - ";
                                echo date('Y-m-d H:i', strtotime($row["departure_time"])) . " - ";
                                echo "$" . $row["fare"];
                                echo "</option>";
                            }
                        }
                        ?>
                    </select>
                </div>
                
                <div class="form-group">
                    <label for="customer_name">Customer Name:</label>
                    <input type="text" id="customer_name" name="customer_name" value="<?php echo $customer_name; ?>" required>
                </div>
                
                <div class="form-group">
                    <label for="email">Email:</label>
                    <input type="email" id="email" name="email" value="<?php echo $email; ?>" required>
                </div>
                
                <div class="form-group">
                    <label for="seat_no">Seat Number:</label>
                    <input type="number" id="seat_no" name="seat_no" value="<?php echo $seat_no; ?>" required>
                </div>
                
                <input type="submit" value="Update Booking">
                <a href="view_bookings.php" style="text-decoration: none; padding: 10px 20px; background-color: #95a5a6; color: white; border-radius: 4px;">Cancel</a>
            </form>
        </div>
    </div>
</body>
</html>

