<?php
include("../db/connect.php");
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>View Routes - Bus Reservation System</title>
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
            <h2>Route Management</h2>
            <a href="add_route.php" class="add-btn" style="display: inline-block; margin-bottom: 20px;">Add New Route</a>
            
            <table>
                <thead>
                    <tr>
                        <th>Route ID</th>
                        <th>Source</th>
                        <th>Destination</th>
                        <th>Distance (km)</th>
                        <th>Duration</th>
                        <th>Actions</th>
                    </tr>
                </thead>
                <tbody>
                    <?php
                    $sql = "SELECT * FROM routes";
                    $result = $conn->query($sql);
                    
                    if ($result->num_rows > 0) {
                        while($row = $result->fetch_assoc()) {
                            echo "<tr>";
                            echo "<td>" . $row["route_id"] . "</td>";
                            echo "<td>" . $row["source"] . "</td>";
                            echo "<td>" . $row["destination"] . "</td>";
                            echo "<td>" . $row["distance"] . "</td>";
                            echo "<td>" . $row["duration"] . "</td>";
                            echo "<td class='actions'>";
                            echo "<a href='edit_route.php?id=" . $row["route_id"] . "' class='edit-btn'>Edit</a>";
                            echo "<a href='delete_route.php?id=" . $row["route_id"] . "' class='delete-btn' onclick='return confirm(\"Are you sure you want to delete this route?\")'>Delete</a>";
                            echo "</td>";
                            echo "</tr>";
                        }
                    } else {
                        echo "<tr><td colspan='6'>No routes found</td></tr>";
                    }
                    ?>
                </tbody>
            </table>
        </div>
    </div>
</body>
</html>
