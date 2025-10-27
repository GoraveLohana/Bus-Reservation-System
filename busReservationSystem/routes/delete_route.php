<?php
include("../db/connect.php");

$route_id = $_GET['id'];

try {
    $sql = "DELETE FROM routes WHERE route_id = '$route_id'";
    
    if ($conn->query($sql) === TRUE) {
        header("Location: view_routes.php");
        exit();
    } else {
        echo "Error deleting route: " . $conn->error;
    }
} catch (mysqli_sql_exception $e) {
    echo "Cannot delete route. It may be referenced in schedules.";
}
?>
