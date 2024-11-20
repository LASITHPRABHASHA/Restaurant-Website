<?php
$servername = "localhost";
$username = "root";
$password = "";
$dbname = "myResturantDB";

$conn = new mysqli($servername, $username, $password, $dbname);

// Check connection
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

// Get the form data
$firstname = isset($_POST['firstname']) ? $_POST['firstname'] : '';
$lastname = isset($_POST['lastname']) ? $_POST['lastname'] : '';
$email = isset($_POST['email']) ? $_POST['email'] : '';
$number = isset($_POST['number']) ? $_POST['number'] : '';
$address = isset($_POST['address']) ? $_POST['address'] : '';
$cardnumber = isset($_POST['cardnumber']) ? $_POST['cardnumber'] : '';
$password = isset($_POST['password']) ? $_POST['password'] : '';
$confirmpassword = isset($_POST['confirmpassword']) ? $_POST['confirmpassword'] : '';

// Validate password match
if ($password != $confirmpassword) {
    echo "Password and Confirm Password do not match.";
    // You might want to redirect the user back to the signup form or handle this differently.
    exit();
}

// Check if email already exists
$check_email_query = "SELECT * FROM ResturantUsers WHERE email = ?";
$check_email_stmt = $conn->prepare($check_email_query);
$check_email_stmt->bind_param("s", $email);
$check_email_stmt->execute();
$check_email_result = $check_email_stmt->get_result();

if ($check_email_result->num_rows > 0) {
    echo "An account with this email already exists. Use a different one or log in.";
// Redirect the user back to the signup form or handle this differently.
    exit();
}

// Hash the password using password_hash()
$hashed_password = password_hash($password, PASSWORD_DEFAULT);

// Insert data into the database using prepared statements
$insert_query = $conn->prepare("INSERT INTO ResturantUsers (firstname, lastname, email, number, address, cardnumber, password) VALUES (?, ?, ?, ?, ?, ?, ?)");
$insert_query->bind_param("sssssss", $firstname, $lastname, $email, $number, $address, $cardnumber, $hashed_password);

if ($insert_query->execute()) {
    // Redirect the user to the main page after successful account creation
    header("Location: CreateAccount.html");
    exit();
} else {
    echo "Error: Unable to create account. Please try again later.";
}

// Close prepared statements and the database connection
$check_email_stmt->close();
$insert_query->close();
$conn->close();
?>
