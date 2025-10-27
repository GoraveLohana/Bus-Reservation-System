<?php
include("../db/connect.php");

$schedule_id = $_GET['id'];

try {
    $sql = "DELETE FROM schedule WHERE schedule_id = '$schedule_id'";
    
    if ($conn->query($sql) === TRUE) {
        header("Location: view_schedules.php");
        exit();
    } else {
        echo "Error deleting schedule: " . $conn->error;
    }
} catch (mysqli_sql_exception $e) {
    echo "Cannot delete schedule. It may be referenced in bookings.";
}
?>

