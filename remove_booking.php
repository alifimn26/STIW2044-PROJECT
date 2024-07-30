<?php
session_start();
include('db.php');

// Check if user is logged in
if (!isset($_SESSION['user_id'])) {
    header("Location: signin.html");
    exit();
}

if ($_SERVER["REQUEST_METHOD"] == "GET" && isset($_GET['id'])) {
    $booking_id = $_GET['id'];

    // Delete booking
    $sql = "DELETE FROM bookings WHERE id='$booking_id' AND user_id='" . $_SESSION['user_id'] . "'";
    if ($conn->query($sql) === TRUE) {
        header("Location: BookingList.php");
        exit();
    } else {
        echo "Error deleting record: " . $conn->error;
    }
}
?>
