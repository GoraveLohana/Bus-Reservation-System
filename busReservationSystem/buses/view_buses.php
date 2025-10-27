<?php
include("../db/connect.php");
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>View Buses - Bus Reservation System</title>
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
            <h2>Bus Management</h2>
            <a href="add_bus.php" class="add-btn" style="display: inline-block; margin-bottom: 20px;">Add New Bus</a>
            
            <table>
                <thead>
                    <tr>
                        <th>Bus ID</th>
                        <th>Bus Number</th>
                        <th>Bus Name</th>
                        <th>Total Seats</th>
                        <th>Type</th>
                        <th>Actions</th>
                    </tr>
                </thead>
                <tbody>
                    <?php
                    $sql = "SELECT * FROM buses";
                    $result = $conn->query($sql);
                    
                    if ($result->num_rows > 0) {
                        while($row = $result->fetch_assoc()) {
                            echo "<tr>";
                            echo "<td>" . $row["bus_id"] . "</td>";
                            echo "<td>" . $row["bus_number"] . "</td>";
                            echo "<td>" . $row["bus_name"] . "</td>";
                            echo "<td>" . $row["total_seats"] . "</td>";
                            echo "<td>" . $row["type"] . "</td>";
                            echo "<td class='actions'>";
                            echo "<a href='edit_bus.php?id=" . $row["bus_id"] . "' class='edit-btn'>Edit</a>";
                            echo "<a href='delete_bus.php?id=" . $row["bus_id"] . "' class='delete-btn' onclick='return confirm(\"Are you sure you want to delete this bus?\")'>Delete</a>";
                            echo "</td>";
                            echo "</tr>";
                        }
                    } else {
                        echo "<tr><td colspan='6'>No buses found</td></tr>";
                    }
                    ?>
                </tbody>
            </table>
        </div>
    </div>
</body>
</html>
