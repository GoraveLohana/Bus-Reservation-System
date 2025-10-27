<?php
include("../db/connect.php");
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>View Bookings - Bus Reservation System</title>
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
            <h2>Booking Management</h2>
            <a href="add_booking.php" class="add-btn" style="display: inline-block; margin-bottom: 20px;">Add New Booking</a>
            
            <table>
                <thead>
                    <tr>
                        <th>Booking ID</th>
                        <th>Schedule</th>
                        <th>Customer Name</th>
                        <th>Email</th>
                        <th>Seat No</th>
                        <th>Booking Date</th>
                        <th>Actions</th>
                    </tr>
                </thead>
                <tbody>
                    <?php
                    $sql = "SELECT b.*, s.departure_time, s.arrival_time, s.fare, 
                                   bus.bus_name, bus.bus_number,
                                   r.source, r.destination
                            FROM bookings b 
                            JOIN schedule s ON b.schedule_id = s.schedule_id
                            JOIN buses bus ON s.bus_id = bus.bus_id
                            JOIN routes r ON s.route_id = r.route_id";
                    $result = $conn->query($sql);
                    
                    if ($result->num_rows > 0) {
                        while($row = $result->fetch_assoc()) {
                            echo "<tr>";
                            echo "<td>" . $row["booking_id"] . "</td>";
                            echo "<td>" . $row["bus_name"] . " (" . $row["bus_number"] . ")<br>";
                            echo $row["source"] . " to " . $row["destination"] . "<br>";
                            echo "Dep: " . date('Y-m-d H:i', strtotime($row["departure_time"])) . "<br>";
                            echo "Fare: PKR " . $row["fare"] . "</td>";
                            echo "<td>" . $row["customer_name"] . "</td>";
                            echo "<td>" . $row["email"] . "</td>";
                            echo "<td>" . $row["seat_no"] . "</td>";
                            echo "<td>" . date('Y-m-d H:i', strtotime($row["booking_date"])) . "</td>";
                            echo "<td class='actions'>";
                            echo "<a href='edit_booking.php?id=" . $row["booking_id"] . "' class='edit-btn'>Edit</a>";
                            echo "<a href='delete_booking.php?id=" . $row["booking_id"] . "' class='delete-btn' onclick='return confirm(\"Are you sure you want to delete this booking?\")'>Delete</a>";
                            echo "</td>";
                            echo "</tr>";
                        }
                    } else {
                        echo "<tr><td colspan='7'>No bookings found</td></tr>";
                    }
                    ?>
                </tbody>
            </table>
        </div>
    </div>
</body>
</html>

