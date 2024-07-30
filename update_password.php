<?php
require 'db.php';

// Function to handle errors
function handle_error($message) {
    echo "<script>
        alert('$message');
        window.location.href = 'reset_password.php';
    </script>";
    exit();
}

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    if (isset($_POST['email']) && !empty($_POST['email']) && isset($_POST['new_password']) && !empty($_POST['new_password'])) {
        $email = $_POST['email'];
        $new_password = password_hash($_POST['new_password'], PASSWORD_DEFAULT);
        
        // Update the password in the database
        $stmt = $conn->prepare("UPDATE users SET password = ? WHERE email = ?");
        if ($stmt === false) {
            handle_error('Error preparing statement: ' . $conn->error);
        }

        $stmt->bind_param("ss", $new_password, $email);

        if ($stmt->execute()) {
            // Check if any row was updated
            if ($stmt->affected_rows > 0) {
                echo "<script>
                    alert('Your password has been updated.');
                    window.location.href = 'signin.html';
                </script>";
            } else {
                    echo "<script>
                    alert('Email not found.');
                    window.location.href = 'signin.html';
                </script>";
            }
        } else {
            handle_error('Error updating password. Please try again.');
        }

        $stmt->close();
    } else {
        handle_error('Email and new password are required.');
    }
} else {
    handle_error('Invalid request method.');
}

$conn->close();
?>