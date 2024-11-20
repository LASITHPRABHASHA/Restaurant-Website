<?php
$servername = "localhost";
$username = "root";
$password = "";
$dbname = "myResturantDB";

$conn = new mysqli($servername, $username, $password, $dbname);

if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

function sanitize_input($data) {
    $data = trim($data);
    $data = stripslashes($data);
    $data = htmlspecialchars($data);
    return $data;
}

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $email = sanitize_input($_POST["email"]);
    $password = sanitize_input($_POST["password"]);

    // Check if the user exists
    $check_user_query = "SELECT * FROM ResturantUsers WHERE Email = '$email'";
    $result = $conn->query($check_user_query);

    if ($result->num_rows > 0) {
        // Update the user's password
        $hashed_password = password_hash($password, PASSWORD_DEFAULT);
        $update_password_query = "UPDATE ResturantUsers SET Password = '$hashed_password' WHERE Email = '$email'";

        if ($conn->query($update_password_query) === TRUE) {
            echo "Password reset successfully!";
        } else {
            echo "Error updating record: " . $conn->error;
        }

    } else {
        echo "User not found!";
    }
}

$conn->close();
?>
