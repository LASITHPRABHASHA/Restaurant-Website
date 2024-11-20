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

    $sql = "SELECT * FROM ResturantUsers WHERE Email = '$email'";
    $result = $conn->query($sql);

    if ($result->num_rows > 0) {
        $row = $result->fetch_assoc();
        $hashed_password = $row["password"];

        if (password_verify($password, $hashed_password)) {
            echo "Login successful!";
            // Redirect to the home page
            header("Location: HomePage.html");
            exit(); // Ensure script stops execution after redirect
        } else {
            echo "Login failed!";
        }
    } else {
        echo "User not found!";
    }
}

$conn->close();
?>
