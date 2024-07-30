<?php
session_start();
header('Content-Type: application/json');

$servername = "localhost";
$username = "root";
$password = "";
$dbname = "travel_app";

// Create connection
$conn = new mysqli($servername, $username, $password, $dbname);

// Check connection
if ($conn->connect_error) {
  die(json_encode(['success' => false, 'message' => 'Connection failed: ' . $conn->connect_error]));
}

if ($_SERVER["REQUEST_METHOD"] == "POST") {
  if (isset($_SESSION['user_id'])) {
    $user_id = $_SESSION['user_id'];
    $name = $_POST['myname1'];
    $email = $_POST['myemail'];
    $phone = $_POST['myphone'];
    $age = $_POST['myage'];
    $gender = $_POST['gender'];
    $departure_date = $_POST['departuredate'];
    $return_date = $_POST['returndate'];
    $destination = $_POST['destinations'];
    $package_type = $_POST['packages'];

    $sql = "INSERT INTO bookings (user_id, name, email, phone, age, gender, departure_date, return_date, destination, package_type) VALUES (?, ?, ?, ?, ?, ?, ?, ?, ?, ?)";
    $stmt = $conn->prepare($sql);
    if ($stmt === false) {
      echo json_encode(['success' => false, 'message' => 'Error preparing statement: ' . $conn->error]);
      exit();
    }

    $stmt->bind_param("isssisssss", $user_id, $name, $email, $phone, $age, $gender, $departure_date, $return_date, $destination, $package_type);

    if ($stmt->execute()) {
      echo json_encode(['success' => true]);
    } else {
      echo json_encode(['success' => false, 'message' => 'Error executing statement: ' . $stmt->error]);
    }

    $stmt->close();
  } else {
    echo json_encode(['success' => false, 'message' => 'User not logged in.']);
  }

  $conn->close();
} else {
  echo json_encode(['success' => false, 'message' => 'Invalid request method.']);
}
?>
