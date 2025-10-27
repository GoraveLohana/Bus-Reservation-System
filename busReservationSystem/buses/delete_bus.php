<?php
include("../db/connect.php");

$bus_id = $_GET['id'];

try {
    $sql = "DELETE FROM buses WHERE bus_id = '$bus_id'";
    
    if ($conn->query($sql) === TRUE) {
        header("Location: view_buses.php");
        exit();
    } else {
        echo "Error deleting bus: " . $conn->error;
    }
} catch (mysqli_sql_exception $e) {
    echo "Cannot delete bus. It may be referenced in schedules or bookings.";
}
?>
