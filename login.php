<?php
session_start();
include('db.php');

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $email = $_POST['email'];
    $password = $_POST['password'];

    // Secure the inputs
    $email = $conn->real_escape_string($email);
    $password = $conn->real_escape_string($password);

    // Check if user exists in the database
    $sql = "SELECT * FROM users WHERE email='$email'";
    $result = $conn->query($sql);

    if ($result->num_rows > 0) {
        // User found, verify the password
        $row = $result->fetch_assoc();
        if (password_verify($password, $row['password'])) {
            // Password is correct, set session variables
            $_SESSION['user_id'] = $row['id'];
            $_SESSION['user_email'] = $row['email'];
            
            // Redirect to home page
            header("Location: index.html");
            exit();
        } else {
            echo "<script>alert('Invalid password'); window.location.href = 'signin.html';</script>";
        }
    } else {
        echo "<script>alert('Invalid email'); window.location.href = 'signin.html';</script>";
    }

    $conn->close();
}
?>
