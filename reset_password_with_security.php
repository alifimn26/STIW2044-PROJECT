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
    if (isset($_POST['email']) && isset($_POST['security_answer']) && isset($_POST['new_password']) &&
        !empty($_POST['email']) && !empty($_POST['security_answer']) && !empty($_POST['new_password'])) {

        $email = $_POST['email'];
        $security_answer = $_POST['security_answer'];
        $new_password = password_hash($_POST['new_password'], PASSWORD_DEFAULT);

        // Fetch stored security answer
        $stmt = $conn->prepare("SELECT security_answer FROM users WHERE email = ?");
        if ($stmt === false) {
            handle_error('Error preparing statement: ' . $conn->error);
        }

        $stmt->bind_param("s", $email);
        $stmt->execute();
        $stmt->store_result();
        $stmt->bind_result($stored_answer);
        $stmt->fetch();

        if ($stmt->num_rows > 0 && password_verify($security_answer, $stored_answer)) {
            // Update the password in the database
            $stmt = $conn->prepare("UPDATE users SET password = ? WHERE email = ?");
            if ($stmt === false) {
                handle_error('Error preparing statement: ' . $conn->error);
            }

            $stmt->bind_param("ss", $new_password, $email);

            if ($stmt->execute()) {
                if ($stmt->affected_rows > 0) {
                    echo "<script>
                        alert('Your password has been updated.');
                        window.location.href = 'signin.html';
                    </script>";
                } else {
                    handle_error('Email not found.');
                }
            } else {
                handle_error('Error updating password. Please try again.');
            }

            $stmt->close();
        } else {
            echo "<script>
            alert('Incorrect security answer.');
            window.location.href = 'signin.html';
        </script>";
        }
    } else {
        handle_error('Email, security answer, and new password are required.');
    }
} else {
    handle_error('Invalid request method.');
}

$conn->close();
?>
