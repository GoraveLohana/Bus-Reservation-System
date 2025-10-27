<?php
include("../db/connect.php");

$booking_id = $_GET['id'];

try {
    $sql = "DELETE FROM bookings WHERE booking_id = '$booking_id'";
    
    if ($conn->query($sql) === TRUE) {
        header("Location: view_bookings.php");
        exit();
    } else {
        echo "Error deleting booking: " . $conn->error;
    }
} catch (mysqli_sql_exception $e) {
    echo "Error deleting booking.";
}
?>

