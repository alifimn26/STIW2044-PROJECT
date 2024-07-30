<?php
include('db.php');
if(isset($_POST['search'])) {
    $booking_id = $_POST['booking_id'];
    // Search booking logic
    $query = "SELECT * FROM bookings WHERE id='$booking_id'";
    $result = mysqli_query($conn, $query);
    if(mysqli_num_rows($result) > 0) {
        $booking = mysqli_fetch_assoc($result);
        echo "Booking found: " . json_encode($booking);
    } else {
        echo "No booking found with the given ID.";
    }
}
?>
<!DOCTYPE html>
<html>
<head>
    <title>Search Booking</title>
</head>
<body>
    <h2>Search Booking</h2>
    <form method="post" action="search_booking.php">
        <label for="booking_id">Booking ID:</label>
        <input type="text" id="booking_id" name="booking_id" required>
        <input type="submit" name="search" value="Search Booking">
    </form>
</body>
</html>
