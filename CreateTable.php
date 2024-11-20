<?php
$servername = "localhost";
$username = "root";
$password = "";
$dbname = "myResturantDB";

// Create connection
$conn = new mysqli($servername, $username, $password);

// Check connection
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

// Switch to the 'myResturantDB' database
$conn->select_db($dbname);

// Check if the 'ResturantUsers' table exists
$tableExistsQuery = "SHOW TABLES LIKE 'ResturantUsers'";
$tableExistsResult = $conn->query($tableExistsQuery);

if ($tableExistsResult->num_rows > 0) {
    echo "Table already exists.<br>";
} else {
    // Create 'ResturantUsers' table
    $createTableQuery = "CREATE TABLE IF NOT EXISTS ResturantUsers (
        id INT AUTO_INCREMENT PRIMARY KEY,
        firstname VARCHAR(50) NOT NULL,
        lastname VARCHAR(50) NOT NULL,
        email VARCHAR(50) NOT NULL,
        number VARCHAR(15) NOT NULL,
        address VARCHAR(255) NOT NULL,
        cardnumber VARCHAR(16) NOT NULL,
        password VARCHAR(255) NOT NULL
    )";
    if ($conn->query($createTableQuery) === FALSE) {
        echo "Error creating table: " . $conn->error;
    } else {
        echo "Table creation successful.<br>";

        if ($_SERVER["REQUEST_METHOD"] == "POST") {
            // Get values from the form (sanitize and validate as needed)
            $firstname = $conn->real_escape_string($_POST["firstname"]);
            $lastname = $conn->real_escape_string($_POST["lastname"]);
            $email = $conn->real_escape_string($_POST["email"]);
            $number = $conn->real_escape_string($_POST["number"]);
            $address = $conn->real_escape_string($_POST["address"]);
            $cardnumber = $conn->real_escape_string($_POST["cardnumber"]);
            $password = $conn->real_escape_string($_POST["password"]);

            // Use prepared statement to prevent SQL injection
            $stmt = $conn->prepare("INSERT INTO ResturantUsers (firstname, lastname, email, number, address, cardnumber, password) VALUES (?, ?, ?, ?, ?, ?, ?)");
            $stmt->bind_param("sssssss", $firstname, $lastname, $email, $number, $address, $cardnumber, $password);

            if ($stmt->execute()) {
                echo "Registration successful";
            } else {
                echo "Error: " . $stmt->error;
            }

            // Close the prepared statement
            $stmt->close();
        }
    }
}

// Close connection
$conn->close();
?>
