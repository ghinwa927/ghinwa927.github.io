<?php
header("Access-Control-Allow-Origin: *"); // Allow requests from any origin
header("Access-Control-Allow-Methods: GET, POST, OPTIONS"); // Allow GET, POST, OPTIONS requests
header("Access-Control-Allow-Headers: Content-Type, Authorization"); // Allow Content-Type and Authorization headers
require 'config.php'; // Ensure config.php includes the database connection setup
session_start();

if (!empty($_SESSION["id"])) {
    header("Location: index.html");
    exit;
}

$conn = mysqli_connect(db_server,db_user,db_password,db_dname);

if($conn){
// Function to validate the form input
function validateInput($data) {
    $data = trim($data);
    $data = stripslashes($data);
    $data = htmlspecialchars($data);
    return $data;
}

// Error messages
$nameErr = $emailErr = $passwordErr = $confirmationPasswordErr = "";
$name = $email = $password = $confirmationPassword = "";
$isValid = true;

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    // Validate name
    if (empty($_POST["name"])) {
        $nameErr = "Name is required";
        $isValid = false;
    } else {
        $name = validateInput($_POST["name"]);
        if (!preg_match("/^[a-zA-Z-' ]*$/", $name)) {
            echo "<script> alert ('Only letters and white space allowed');</script>";
            $isValid = false;
        }
    }

    // Validate email
    if (empty($_POST["email"])) {
        $emailErr = "Email is required";
        $isValid = false;
    } else {
        $email = validateInput($_POST["email"]);
        if (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
            echo "<script> alert ('Invalid email format');</script>";
            $isValid = false;
        }
    }

    // Validate password
    if (empty($_POST["password"])) {
        $passwordErr = "Password is required";
        $isValid = false;
    } else {
        $password = validateInput($_POST["password"]);
        if (strlen($password) < 8) {
            echo "<script> alert ('Password must be at least 8 characters long');</script>";
            $isValid = false;
        }
    }

    // Validate confirmation password
    if (empty($_POST["confirmationpassword"])) {
        $confirmationPasswordErr = "Password confirmation is required";
        $isValid = false;
    } else {
        $confirmationPassword = validateInput($_POST["confirmationpassword"]);
        if ($password !== $confirmationPassword) {
            $confirmationPasswordErr = "Passwords do not match";
            $isValid = false;
        }
    }

    // If validation passes, process the data
    if ($isValid) {
        $hashedPassword = password_hash($password, PASSWORD_DEFAULT);

        // Check for duplicate entries
        $stmt = $conn->prepare("SELECT * FROM user WHERE name = ? OR email = ?");
        $stmt->bind_param("ss", $name, $email);
        $stmt->execute();
        $result = $stmt->get_result();

        if ($result->num_rows > 0) {
            echo "<script>alert('Username or Email has already been taken');</script>";
        } else {
            // Insert the user into the database
            $stmt = $conn->prepare("INSERT INTO user (name, password, email) VALUES (?, ?, ?)");
            $stmt->bind_param("sss", $name, $hashedPassword, $email);
            if ($stmt->execute()) {
                echo "<script>alert('Registration successful');</script>";
            } else {
                echo "<script>alert('Error registering user');</script>";
            }
        }
        $stmt->close();
    }
}
}
$conn->close();
?>


<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Registration</title>
    <link rel="stylesheet" href="style.css">
    <style>
          body {
            background-image: url('backgroud(registration).jpg'); /* Path to your image */
            background-size: cover; /* Make the image cover the entire page */
            background-position: center; /* Center the image */
            background-repeat: no-repeat; /* Prevent repeating the image */
            margin: 0; /* Remove default margin */
            font-family: Arial, sans-serif; /* Optional: Set the font */
        }
        </style>
</head>
<body>
    
<h2 id="regi">Registration</h2>

<form action="registration.php" method="post"  id="rform">

<label for="name" id="RL">Name:</lable>
<input type="text" name="name" id="nameR" required placeholder="Name"> <br>

<label for="email" iD="RL">Email:</lable>
<input type="text" name="email" id="emailR" required placeholder="Email"> <br>

<label for="password" id="RL">Passwrod:</lable>
<input type="password" name="password" id="passwordR" required placeholder="password"> <br>

<label for="confirmationpassword" id="RL">Confirm password:</lable>
<input type="password" name="confirmationpassword" id="confirmationpasswordR" required placeholder="confirm password"> <br>

<button type="submit" name="submit" id="submitR" >Register</button>

</form>

</body>
</html>