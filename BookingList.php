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
$search_query = "";
if (isset($_POST['search'])) {
    $search_query = $_POST['search'];
    $sql = "SELECT * FROM bookings WHERE user_id='$user_id' AND (name LIKE '%$search_query%' OR email LIKE '%$search_query%' OR phone LIKE '%$search_query%' OR destination LIKE '%$search_query%' OR package_type LIKE '%$search_query%')";
} else {
    $sql = "SELECT * FROM bookings WHERE user_id='$user_id'";
}

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
    <style>/* Add this to your existing styles.css file */

/* Global Styles */
* {
    box-sizing: border-box;
    margin: 0;
    padding: 0;
    font-family: 'Kumbh Sans', sans-serif;
    scroll-behavior: smooth;
    list-style: none;
}

body {
    overflow-x: hidden;
}

.navbar {
    background: #131313;
    height: 80px;
    display: flex;
    justify-content: center;
    align-items: center;
    font-size: 1.2rem;
    position: sticky;
    top: 0;
    z-index: 999;
}

.navbar__container {
    display: flex;
    justify-content: space-between;
    height: 80px;
    z-index: 1;
    width: 100%;
    max-width: 1200px;
    margin-right: 0;
    margin-left: 1%;
    padding-right: 0;
    padding-left: 0;
}

#navbar__logo {
    background-color: #ff8177;
    background-image: linear-gradient(to top, #ff0844 0%, #ffb199 100%);
    background-size: 100%;
    -webkit-background-clip: text;
    -moz-background-clip: text;
    -webkit-text-fill-color: transparent;
    -moz-text-fill-color: transparent;
    display: flex;
    align-items: center;
    cursor: pointer;
    text-decoration: none;
    font-size: 2rem;
}

.fa-globe-europe {
    margin-right: 0.5rem;
}

.navbar__menu {
    font-weight: bold;
    display: flex;
    align-items: center;
    list-style: none;
    text-align: center;
}

.navbar__item {
    height: 80px;
}

.navbar__links {
    color: #fff;
    display: inline-flex;
    align-items: center;
    justify-content: center;
    text-decoration: none;
    padding: 0 1rem;
    height: 100%;
}

.navbar__btn {
    display: flex;
    justify-content: center;
    align-items: center;
    padding: 0 0.5rem;
    width: 100%;
}

.button, .buttonout, .buttonin {
    display: flex;
    justify-content: center;
    align-items: center;
    text-decoration: none;
    padding: 10px 20px;
    height: 100%;
    width: 100%;
    border: none;
    outline: none;
    border-radius: 4px;
    color: #fff;
}

.button {
    background: #eb2711;
}

.buttonout {
    background: #eb2711;
}

.buttonin {
    background: #00b409;
}

.button:hover {
    background: #6b0000;
    transition: all 0.3s ease;
}

.buttonin:hover {
    background: #125300;
    transition: all 0.3s ease;
}

.navbar__links:hover {
    color: #f77062;
    transition: all 0.3s ease;
}

@media screen and (max-width: 960px) {
    .navbar__container {
        display: flex;
        justify-content: space-between;
        height: 80px;
        z-index: 1;
        width: 100%;
        max-width: 1300px;
        padding: 0;
    }

    .navbar__menu {
        display: grid;
        grid-template-columns: auto;
        object-position: center;
        margin: 0;
        width: 100%;
        position: absolute;
        top: -1000px;
        opacity: 1;
        transition: all 0.5s ease;
        height: 50vh;
        z-index: -1;
    }

    .navbar__menu.active {
        background: #131313;
        margin: 0;
        margin-left: -4px;
        top: 100%;
        opacity: 1;
        transition: all 0.5s ease;
        z-index: 99;
        height: 60vh;
        font-size: 1.6rem;
    }

    #navbar__logo {
        padding-left: 25px;
    }

    .navbar__toggle .bar {
        width: 25px;
        height: 3px;
        margin: 5px auto;
        transition: all 0.3s ease-in-out;
        background: #fff;
    }

    .navbar__item {
        width: 100%;
    }

    .navbar__links {
        text-align: center;
        padding: 2rem;
        width: 100%;
        display: table;
    }

    .navbar__btn {
        padding-bottom: 2rem;
    }

    .button, .buttonin {
        display: flex;
        justify-content: center;
        align-items: center;
        width: 80%;
        height: 80px;
        margin: 0;
    }

    #mobile-menu {
        position: absolute;
        top: 20%;
        right: 5%;
        transform: translate(5%, 20%);
    }

    .navbar__toggle .bar {
        display: block;
        cursor: pointer;
    }

    #mobile-menu.is-active .bar:nth-child(2) {
        opacity: 0;
    }

    #mobile-menu.is-active .bar:nth-child(1) {
        transform: translateY(8px) rotate(45deg);
    }

    #mobile-menu.is-active .bar:nth-child(3) {
        transform: translateY(-8px) rotate(-45deg);
    }
}

/* booking Content */
.booking {
    background-color: #ffffff;
}

.booking__container {
    width: 100%;
    display: flex;
    flex-direction: column;
    align-items: center;
    justify-content: top;
    text-align: center;
    margin: 0 auto;
    height: 100%;
    min-height: 100vh;
    background-color: #0c0a0a;
    

}

.booking__content {
    width: 100%;
    padding: 20px;
    margin: 0 ;
    background-size: cover;
}

.booking__content h2 {
    font-size: 5rem;
    background-color: #ff8177;
    background-image: linear-gradient(to top, #ff0844 0%, #ffb199 100%);
    background-size: 100%;
    -webkit-background-clip: text;
    -moz-background-clip: text;
    -webkit-text-fill-color: transparent;
    -moz-text-fill-color: transparent;
    margin-bottom: 20px;
}

.search-container {
    margin-bottom: 20px;
    text-align: center;
}

.search-container input[type="text"] {
    padding: 8px;
    width: 80%;
    max-width: 300px;
    margin-right: 10px;
}

.search-container input[type="submit"] {
    padding: 8px 15px;
    background-color: #007BFF;
    color: white;
    border: none;
    cursor: pointer;
}

table.booking-table {
    background-color: white;
    width: 100%;
    border-collapse: collapse;
    overflow-x: auto;
    margin-top: 0; /* Ensure table is at the top */
    font-size: 0.9rem; /* Adjust font size to make table smaller */
}

table.booking-table, th, td {
    border: 1px solid #ddd;
}

table.booking-table th, table.booking-table td {
    padding: 8px; /* Reduce padding to make table smaller */
    text-align: left;
    white-space: nowrap;
}

table.booking-table th {
    background-color: #f2f2f2;
}

.action-buttons {
    display: flex;
    gap: 5px; /* Reduce gap to make action buttons smaller */
}

.btn-delete {
    padding: 5px 10px;
    text-decoration: none;
    color: white;
    background-color: #f44336;
}

@media screen and (max-width: 768px) {
    table.booking-table {
    background-color: white;
    width: 100%;
    border-collapse: collapse;
    overflow-x: auto;
    display: block;
    margin-top: 0; /* Ensure table is at the top */
    font-size: 0.9rem; /* Adjust font size to make table smaller */
}

.booking__content h2 {
    font-size: 2rem;
    background-color: #ff8177;
    background-image: linear-gradient(to top, #ff0844 0%, #ffb199 100%);
    background-size: 100%;
    -webkit-background-clip: text;
    -moz-background-clip: text;
    -webkit-text-fill-color: transparent;
    -moz-text-fill-color: transparent;
    margin-bottom: 20px;
}

.search-container {
    margin-bottom: 20px;
    text-align: center;
}

.searchbox{
    margin-bottom: 10px;
}

.search-container input[type="text"] {
    padding: 8px;
    width: 70%;
    max-width: 300px;
    margin-right: 10px;
}

}


    



/* Footer */
.footer {
    background-color: rgb(21, 74, 74);
}

.foot {
    padding: 20px 0;
}

.footer-content {
    display: flex;
    flex-wrap: wrap;
    justify-content: space-around;
}

.footlinks h4 {
    margin-top: 30px;
    font-size: 20px;
    font-weight: 600;
    color: white;
    margin-bottom: 30px;
    position: relative;
}

.footlinks h4::before {
    content: "";
    position: absolute;
    height: 2px;
    width: 70px;
    left: 0;
    bottom: -7px;
    background: white;
}

.footlinks ul li {
    margin-bottom: 15px;
}

.footlinks ul li a {
    font-size: 17px;
    color: #dddddd;
    display: block;
    transition: ease 0.30s;
}

.footlinks ul li a:hover {
    transform: translate(6px);
    color: white;
}

.social-icons a {
    height: 40px;
    width: 40px;
    margin: 4px;
    font-size: 30px;
    color: #101010;
    background-color: white;
    border-radius: 20px;
    display: inline-flex;
    justify-content: center;
    align-items: center;
    transition: ease 0.30s;
}

.social-icons a:hover {
    transform: scale(1.2);
}

.social a {
    font-size: 25px;
    margin: 4px;
    height: 40px;
    width: 40px;
    color: rgb(0, 0, 0);
    background-color: white;
    display: inline-flex;
    justify-content: center;
    align-items: center;
    border-radius: 20px;
    transition: ease 0.30s;
}

.social a:hover {
    transform: scale(1.2);
}

.end {
    text-align: center;
    padding-top: 60px;
    padding-bottom: 12px;
}

.end p {
    font-size: 15px;
    color: white;
    letter-spacing: 1px;
    font-weight: 300;
}
</style>
</head>
<body>
    <!-- Navbar Section -->
    <nav class="navbar">
        <div class="navbar__container">
            <a href="index.html" id="navbar__logo"><i class="fas fa-globe-europe"></i>JOMTRAVEL</a>
            <div class="navbar__toggle" id="mobile-menu">
                <span class="bar"></span>
                <span class="bar"></span>
                <span class="bar"></span>
            </div>
            <ul class="navbar__menu">
                <li class="navbar__item">
                    <a href="index.html" class="navbar__links">Home</a>
                </li>
                <li class="navbar__item">
                    <a href="packages.html" class="navbar__links">Packages</a>
                </li>
                <li class="navbar__item">
                    <a href="locations.html" class="navbar__links">Location</a>
                </li>
                <li class="navbar__item">
                    <a href="Booking.html" class="navbar__links">Book Now</a>
                </li>
                <li class="navbar__item">
                    <a href="BookingList.php" class="navbar__links">Booking Management</a>
                </li>
                <li class="navbar__btn">
                    <a href="logout.php" class="buttonout">Sign Out</a>
                </li>
            </ul>
        </div>
    </nav>

    <section class="booking__container">
        <div class="booking__content">
            <h2>List of Bookings</h2>
            <div class="search-container">
                <form method="post" action="BookingList.php">
                    <input class="searchbox" type="text" name="search" placeholder="Search bookings" value="<?php echo htmlspecialchars($search_query); ?>">
                    <input type="submit" value="Search">
                </form>
            </div>
            <table class="booking-table">
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
                    <th>Actions</th>
                </tr>
                <?php
                if ($result->num_rows > 0) {
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
                        echo '<td class="action-buttons">';
                        echo '<a href="remove_booking.php?id=' . $row["id"] . '" class="btn-delete" onclick="return confirm(\'Are you sure you want to delete this booking?\')">Delete</a>';
                        echo '</td>';
                        echo "</tr>";
                    }
                } else {
                    echo "<tr><td colspan='11'>No bookings found</td></tr>";
                }
                $conn->close();
                ?>
            </table>
        </div>
    </section>

    <!-- Footer -->
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

    <script>
        const mobileMenu = document.getElementById('mobile-menu');
        const navbarMenu = document.querySelector('.navbar__menu');

        mobileMenu.addEventListener('click', () => {
            mobileMenu.classList.toggle('is-active');
            navbarMenu.classList.toggle('active');
        });
    </script>
</body>
</html>
