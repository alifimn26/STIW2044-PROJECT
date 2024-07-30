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
    if (isset($_POST['email']) && !empty($_POST['email'])) {
        $email = $_POST['email'];

        // Fetch security question
        $stmt = $conn->prepare("SELECT security_question FROM users WHERE email = ?");
        if ($stmt === false) {
            handle_error('Error preparing statement: ' . $conn->error);
        }

        $stmt->bind_param("s", $email);
        $stmt->execute();
        $stmt->store_result();
        $stmt->bind_result($security_question);
        $stmt->fetch();

        if ($stmt->num_rows > 0) {
            echo '
            <form action="reset_password_with_security.php" method="post">
                <input type="hidden" name="email" value="' . htmlspecialchars($email) . '">
                <label for="security_question">' . htmlspecialchars($security_question) . '</label>
                <input type="text" id="security_answer" name="security_answer" required>
                <label for="new_password">New Password:</label>
                <input type="password" id="new_password" name="new_password" required>
                <button class="submitbtn" type="submit">Reset Password</button>
            </form>
            ';
        } else {
            handle_error('No account found with that email address.');
        }

        $stmt->close();
    } else {
        handle_error('Email is required.');
    }
} else {
    handle_error('Invalid request method.');
}

$conn->close();
?>
