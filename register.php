<?php
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $name = $_POST['name'];
    $email = $_POST['email'];
    $phone = $_POST['phone'];
    $age = $_POST['age'];
    $gender = $_POST['gender'];
    $address = $_POST['address'];
    $password = password_hash($_POST['password'], PASSWORD_DEFAULT);
    $security_question = $_POST['security_question'];
    $security_answer = password_hash($_POST['security_answer'], PASSWORD_DEFAULT);

    // Debug: Print email to verify
    // echo "Registering email: " . $email;

    // Connect to the travel_app database
    $conn = new mysqli('localhost', 'root', '', 'travel_app');

    // Check connection
    if ($conn->connect_error) {
        die("Connection failed: " . $conn->connect_error);
    }

    // Check if email already exists
    $sql = "SELECT * FROM users WHERE email = ?";
    $stmt = $conn->prepare($sql);
    $stmt->bind_param("s", $email);
    $stmt->execute();
    $stmt->store_result();
    
    if ($stmt->num_rows > 0) {
        echo "<script>alert('Email already exists'); window.location.href = 'signup.html';</script>";
    } else {
        // Prepare and bind
        $sql = "INSERT INTO users (name, email, phone, age, gender, address, password, security_question, security_answer) VALUES (?, ?, ?, ?, ?, ?, ?, ?, ?)";
        $stmt = $conn->prepare($sql);
        $stmt->bind_param("sssisssss", $name, $email, $phone, $age, $gender, $address, $password, $security_question, $security_answer);

        // Execute the statement
        if ($stmt->execute()) {
            echo "<script>
                    alert('Registration successful');
                    window.location.href = 'signin.html';
                  </script>";
        } else {
            echo "<script>alert('Error: " . $stmt->error . "');</script>";
        }
    }

    // Close the statement and connection
    $stmt->close();
    $conn->close();
}
?>

