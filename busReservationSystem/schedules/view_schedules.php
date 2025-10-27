<?php
include("../db/connect.php");
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>View Schedules - Bus Reservation System</title>
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
            <h2>Schedule Management</h2>
            <a href="add_schedule.php" class="add-btn" style="display: inline-block; margin-bottom: 20px;">Add New Schedule</a>
            
            <table>
                <thead>
                    <tr>
                        <th>Schedule ID</th>
                        <th>Bus</th>
                        <th>Route</th>
                        <th>Departure Time</th>
                        <th>Arrival Time</th>
                        <th>Fare</th>
                        <th>Actions</th>
                    </tr>
                </thead>
                <tbody>
                    <?php
                    $sql = "SELECT s.*, b.bus_name, b.bus_number, r.source, r.destination 
                            FROM schedule s 
                            JOIN buses b ON s.bus_id = b.bus_id 
                            JOIN routes r ON s.route_id = r.route_id";
                    $result = $conn->query($sql);
                    
                    if ($result->num_rows > 0) {
                        while($row = $result->fetch_assoc()) {
                            echo "<tr>";
                            echo "<td>" . $row["schedule_id"] . "</td>";
                            echo "<td>" . $row["bus_name"] . " (" . $row["bus_number"] . ")</td>";
                            echo "<td>" . $row["source"] . " to " . $row["destination"] . "</td>";
                            echo "<td>" . date('Y-m-d H:i', strtotime($row["departure_time"])) . "</td>";
                            echo "<td>" . date('Y-m-d H:i', strtotime($row["arrival_time"])) . "</td>";
                            echo "<td>PKR " . $row["fare"] . "</td>";
                            echo "<td class='actions'>";
                            echo "<a href='edit_schedule.php?id=" . $row["schedule_id"] . "' class='edit-btn'>Edit</a>";
                            echo "<a href='delete_schedule.php?id=" . $row["schedule_id"] . "' class='delete-btn' onclick='return confirm(\"Are you sure you want to delete this schedule?\")'>Delete</a>";
                            echo "</td>";
                            echo "</tr>";
                        }
                    } else {
                        echo "<tr><td colspan='7'>No schedules found</td></tr>";
                    }
                    ?>
                </tbody>
            </table>
        </div>
    </div>
</body>
</html>
