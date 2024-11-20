<?php
$servername = "localhost";
$username = "root";
$password = "";
$dbname = "myResturantDB";

$conn = new mysqli($servername, $username, $password, $dbname);

// Check the  connection
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

// Check if the form was submitted
if ($_SERVER["REQUEST_METHOD"] == "POST" && isset($_POST['submitButton'])) {

    // Get the form data
    $email = isset($_POST['email']) ? $_POST['email'] : '';
    $password = isset($_POST['password']) ? $_POST['password'] : '';
    $number = isset($_POST['number']) ? $_POST['number'] : '';
    $address = isset($_POST['address']) ? $_POST['address'] : '';
    $cardnumber = isset($_POST['card']) ? $_POST['card'] : '';

    // Check if email already exists
    $check_email_query = "SELECT * FROM ResturantUsers WHERE email = ?";
    $check_email_stmt = $conn->prepare($check_email_query);
    $check_email_stmt->bind_param("s", $email);
    $check_email_stmt->execute();
    $check_email_result = $check_email_stmt->get_result();

    if ($check_email_result->num_rows > 0) {
        // Email already exists, check password
        $row = $check_email_result->fetch_assoc();
        $hashed_password_from_db = $row['password'];

        if (password_verify($password, $hashed_password_from_db)) {
            // Passwords match
            echo "Order confirmed. Thank you for registering!";
        } else {
            // Passwords don't match
            echo "Error: Passwords don't match with the previous one.";
        }

        // Close the prepared statement
        $check_email_stmt->close();
    } else {

        // Hash the password using password_hash()
        $hashed_password = password_hash($password, PASSWORD_DEFAULT);

        // Insert data into the database using prepared statements
        $insert_query = $conn->prepare("INSERT INTO ResturantUsers (email, password, number, address, cardnumber) VALUES (?, ?, ?, ?, ?)");
        $insert_query->bind_param("sssss", $email, $hashed_password, $number, $address, $cardnumber);

        if ($insert_query->execute()) {
            // Registration successful
            echo "Order confirmed. Thank you for registering!";
        } else {
            // Registration failed
            echo "Error: Unable to confirm order. Please try again later.";
        }

        // Close the prepared statement
        $insert_query->close();
    }
}

// Close the database connection
$conn->close();
?>
