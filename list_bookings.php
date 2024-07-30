<?php
session_start();
include('db.php');

// Check if user is logged in
if (!isset($_SESSION['user_id'])) {
    header("Location: signin.html");
    exit();
}

$user_id = $_SESSION['user_id'];

// Fetch bookings for the logged-in user
$sql = "SELECT * FROM bookings WHERE user_id='$user_id'";
$result = $conn->query($sql);
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>List of Bookings</title>
    <link rel="stylesheet" href="styles.css">
    <link rel="stylesheet" href="https://use.fontawesome.com/releases/v5.14.0/css/all.css" crossorigin="anonymous">
    <link href="https://fonts.googleapis.com/css2?family=Kumbh+Sans:wght@400;700&display=swap" rel="stylesheet">
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Paytone+One&family=Poppins:wght@100;200;300;400;500;600;700;800;900&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="https://unpkg.com/boxicons@latest/css/boxicons.min.css">
    <style>
        body {
            font-family: Arial, sans-serif;
            margin: 20px;
        }
        h2 {
            color: #333;
        }
        table {
            width: 100%;
            border-collapse: collapse;
        }
        table, th, td {
            border: 1px solid #ddd;
        }
        th, td {
            padding: 10px;
            text-align: left;
        }
        th {
            background-color: #f2f2f2;
        }
    </style>
</head>
<body>
    <nav class="navbar">
        <div class="navbar__container">
            <a href="home.html" id="navbar__logo"><i class="fas fa-globe-europe"></i>JOMTRAVEL</a>
            <div class="navbar__toggle" id="mobile-menu">
                <span class="bar"></span>
                <span class="bar"></span>
                <span class="bar"></span>
            </div>
            <ul class="navbar__menu">
                <li class="navbar__item">
                    <a href="home.html" class="navbar__links">Home</a>
                </li>
                <li class="navbar__item">
                    <a href="packages.html" class="navbar__links">Packages</a>
                </li>
                <li class="navbar__item">
                    <a href="locations.html" class="navbar__links">Location</a>
                </li>
                <li class="navbar__item">
                    <a href="Booking.html" class="navbar__links">Book Now</a>
                <li class="navbar__btn">
                    <a href="logout.php" class="buttonout">Sign Out</a>
                </li>
        </div>
    </nav>

    <h2>List of Bookings</h2>
    <table>
        <tr>
            <th>ID</th>
            <th>Name</th>
            <th>Email</th>
            <th>Phone</th>
            <th>Age</th>
            <th>Gender</th>
            <th>Departure Date</th>
            <th>Return Date</th>
            <th>Destination</th>
            <th>Package</th>
        </tr>
        <?php
        if ($result->num_rows > 0) {
            // Output data of each row
            while($row = $result->fetch_assoc()) {
                echo "<tr>";
                echo "<td>" . $row["id"] . "</td>";
                echo "<td>" . $row["name"] . "</td>";
                echo "<td>" . $row["email"] . "</td>";
                echo "<td>" . $row["phone"] . "</td>";
                echo "<td>" . $row["age"] . "</td>";
                echo "<td>" . $row["gender"] . "</td>";
                echo "<td>" . $row["departure_date"] . "</td>";
                echo "<td>" . $row["return_date"] . "</td>";
                echo "<td>" . $row["destination"] . "</td>";
                echo "<td>" . (isset($row["package_type"]) ? $row["package_type"] : "N/A") . "</td>";
                echo "</tr>";
            }
        } else {
            echo "<tr><td colspan='10'>No bookings found</td></tr>";
        }
        $conn->close();
        ?>
    </table>

    <section class="footer">
        <div class="foot">
            <div class="footer-content">
                <div class="footlinks">
                    <h4>Find Us Here</h4>
                    <div class="social">
                        <a href="" target="_blank"><i class='bx bxl-facebook'></i></a>
                        <a href="" target="_blank"><i class='bx bxl-youtube'></i></a>
                        <a href="" target="_blank"><i class='bx bxl-github'></i></a>
                    </div>
                </div>
            </div>
        </div>

        <div class="end">
            <p>Copyright © 2024 JomTravel Travels All Rights Reserved.</p>
        </div>
    </section>
</body>
</html>
