<?php
include("db/connect.php");

$search_results = [];
$search_type = "";
$search_term = "";

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $search_type = $_POST['search_type'];
    $search_term = $_POST['search_term'];
    
    if (!empty($search_term)) {
        switch($search_type) {
            case 'buses':
                $sql = "SELECT * FROM buses WHERE bus_name LIKE '%$search_term%' OR bus_number LIKE '%$search_term%' OR type LIKE '%$search_term%'";
                break;
            case 'routes':
                $sql = "SELECT * FROM routes WHERE source LIKE '%$search_term%' OR destination LIKE '%$search_term%'";
                break;
            case 'schedules':
                $sql = "SELECT s.*, b.bus_name, b.bus_number, r.source, r.destination 
                        FROM schedule s 
                        JOIN buses b ON s.bus_id = b.bus_id 
                        JOIN routes r ON s.route_id = r.route_id
                        WHERE b.bus_name LIKE '%$search_term%' OR r.source LIKE '%$search_term%' OR r.destination LIKE '%$search_term%'";
                break;
            case 'bookings':
                $sql = "SELECT b.*, s.departure_time, s.arrival_time, s.fare, 
                               bus.bus_name, bus.bus_number,
                               r.source, r.destination
                        FROM bookings b 
                        JOIN schedule s ON b.schedule_id = s.schedule_id
                        JOIN buses bus ON s.bus_id = bus.bus_id
                        JOIN routes r ON s.route_id = r.route_id
                        WHERE b.customer_name LIKE '%$search_term%' OR b.email LIKE '%$search_term%' OR bus.bus_name LIKE '%$search_term%'";
                break;
        }
        
        $result = $conn->query($sql);
        if ($result->num_rows > 0) {
            while($row = $result->fetch_assoc()) {
                $search_results[] = $row;
            }
        }
    }
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Search - Bus Reservation System</title>
    <link rel="stylesheet" href="style.css">
</head>
<body>
    <header>
        <h1>Bus Reservation System</h1>
    </header>

    <nav>
        <ul>
            <li><a href="index.php">Home</a></li>
            <li><a href="buses/view_buses.php">Buses</a></li>
            <li><a href="routes/view_routes.php">Routes</a></li>
            <li><a href="schedules/view_schedules.php">Schedules</a></li>
            <li><a href="bookings/view_bookings.php">Bookings</a></li>
            <li><a href="search.php">Search</a></li>
        </ul>
    </nav>

    <div class="container">
        <div class="search-form">
            <h3>Search System</h3>
            <form method="POST">
                <div class="form-group">
                    <label for="search_type">Search Type:</label>
                    <select id="search_type" name="search_type" required>
                        <option value="">Select Type</option>
                        <option value="buses" <?php if($search_type == "buses") echo "selected"; ?>>Buses</option>
                        <option value="routes" <?php if($search_type == "routes") echo "selected"; ?>>Routes</option>
                        <option value="schedules" <?php if($search_type == "schedules") echo "selected"; ?>>Schedules</option>
                        <option value="bookings" <?php if($search_type == "bookings") echo "selected"; ?>>Bookings</option>
                    </select>
                </div>
                
                <div class="form-group">
                    <label for="search_term">Search Term:</label>
                    <input type="text" id="search_term" name="search_term" value="<?php echo $search_term; ?>" placeholder="Enter search term..." required>
                </div>
                
                <input type="submit" value="Search">
            </form>
        </div>

        <?php if (!empty($search_results)): ?>
        <div class="card">
            <h3>Search Results (<?php echo count($search_results); ?> found)</h3>
            
            <?php if ($search_type == 'buses'): ?>
            <table>
                <thead>
                    <tr>
                        <th>Bus ID</th>
                        <th>Bus Number</th>
                        <th>Bus Name</th>
                        <th>Total Seats</th>
                        <th>Type</th>
                    </tr>
                </thead>
                <tbody>
                    <?php foreach($search_results as $row): ?>
                    <tr>
                        <td><?php echo $row['bus_id']; ?></td>
                        <td><?php echo $row['bus_number']; ?></td>
                        <td><?php echo $row['bus_name']; ?></td>
                        <td><?php echo $row['total_seats']; ?></td>
                        <td><?php echo $row['type']; ?></td>
                    </tr>
                    <?php endforeach; ?>
                </tbody>
            </table>
            
            <?php elseif ($search_type == 'routes'): ?>
            <table>
                <thead>
                    <tr>
                        <th>Route ID</th>
                        <th>Source</th>
                        <th>Destination</th>
                        <th>Distance (km)</th>
                        <th>Duration</th>
                    </tr>
                </thead>
                <tbody>
                    <?php foreach($search_results as $row): ?>
                    <tr>
                        <td><?php echo $row['route_id']; ?></td>
                        <td><?php echo $row['source']; ?></td>
                        <td><?php echo $row['destination']; ?></td>
                        <td><?php echo $row['distance']; ?></td>
                        <td><?php echo $row['duration']; ?></td>
                    </tr>
                    <?php endforeach; ?>
                </tbody>
            </table>
            
            <?php elseif ($search_type == 'schedules'): ?>
            <table>
                <thead>
                    <tr>
                        <th>Schedule ID</th>
                        <th>Bus</th>
                        <th>Route</th>
                        <th>Departure Time</th>
                        <th>Arrival Time</th>
                        <th>Fare</th>
                    </tr>
                </thead>
                <tbody>
                    <?php foreach($search_results as $row): ?>
                    <tr>
                        <td><?php echo $row['schedule_id']; ?></td>
                        <td><?php echo $row['bus_name'] . " (" . $row['bus_number'] . ")"; ?></td>
                        <td><?php echo $row['source'] . " to " . $row['destination']; ?></td>
                        <td><?php echo date('Y-m-d H:i', strtotime($row['departure_time'])); ?></td>
                        <td><?php echo date('Y-m-d H:i', strtotime($row['arrival_time'])); ?></td>
                        <td>$<?php echo $row['fare']; ?></td>
                    </tr>
                    <?php endforeach; ?>
                </tbody>
            </table>
            
            <?php elseif ($search_type == 'bookings'): ?>
            <table>
                <thead>
                    <tr>
                        <th>Booking ID</th>
                        <th>Schedule</th>
                        <th>Customer Name</th>
                        <th>Email</th>
                        <th>Seat No</th>
                        <th>Booking Date</th>
                    </tr>
                </thead>
                <tbody>
                    <?php foreach($search_results as $row): ?>
                    <tr>
                        <td><?php echo $row['booking_id']; ?></td>
                        <td><?php echo $row['bus_name'] . " (" . $row['bus_number'] . ")<br>";
                            echo $row['source'] . " to " . $row['destination'] . "<br>";
                            echo "Dep: " . date('Y-m-d H:i', strtotime($row['departure_time'])); ?></td>
                        <td><?php echo $row['customer_name']; ?></td>
                        <td><?php echo $row['email']; ?></td>
                        <td><?php echo $row['seat_no']; ?></td>
                        <td><?php echo date('Y-m-d H:i', strtotime($row['booking_date'])); ?></td>
                    </tr>
                    <?php endforeach; ?>
                </tbody>
            </table>
            <?php endif; ?>
        </div>
        <?php elseif ($_SERVER['REQUEST_METHOD'] == 'POST' && empty($search_results)): ?>
        <div class="card">
            <p>No results found for your search term.</p>
        </div>
        <?php endif; ?>
    </div>
</body>
</html>
