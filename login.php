
<?php
/*require 'config.php';
if(!empty($_SESSION["id"])){
    header("Location:index.php");
}

if(isset($_POST["submit"])){
$emailorname=$_POST["emailorname"];
$password=$_POST["password"];
$result=myspli_query($conn,"SELECT * FROM user WHERE name='$emailorname' OR email='$emailorname'");
$row=myspli_fetch_assoc($result);

if(mysqli_num_rows($result) >0 ){
    if($password == $row["password"]){
        $_SESSION["login"] = true;
        $_SESSION["id"] = $row["id"];
        header("Location: index.php");
    }
else{
   echo "<script> alert('wrong Password'); </script>";
}
}
else{
    echo "<script> alert('User Not Registered'); </script>";
}
}
?>*/
header("Access-Control-Allow-Origin: *"); // Allow requests from any origin
header("Access-Control-Allow-Methods: GET, POST, OPTIONS"); // Allow GET, POST, OPTIONS requests
header("Access-Control-Allow-Headers: Content-Type, Authorization"); // Allow Content-Type and Authorization headers

echo'hello';
require 'config.php';
session_start();

// Check if the form is submitted
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $email = trim($_POST['emailorname']);
    $password = trim($_POST['passwordL']);
    $error = '';

    // Validate email syntax
    if (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
        $error = 'Invalid email format.';
    } elseif (strlen($password) < 8) {
        $error = 'Password must be at least 8 characters long.';
    }

    if ($error) {
        // Store the error message in the session
        $_SESSION['error'] = $error;
        header("Location: login.php"); // Redirect back to the login page
        exit();
    }

    // Proceed with login logic
    $conn = new mysqli(DB_HOST, DB_USER, DB_PASSWORD, DB_NAME);

    // Check the connection
    if ($conn->connect_error) {
        die('Database connection failed: ' . $conn->connect_error);
    }

    // Prepare a statement to prevent SQL injection
    $stmt = $conn->prepare("SELECT password FROM users WHERE email = ?");
    $stmt->bind_param("s", $email);
    $stmt->execute();
    $stmt->store_result();

    if ($stmt->num_rows > 0) {
        // Fetch the hashed password
        $stmt->bind_result($hashed_password);
        $stmt->fetch();

        // Verify the password
        if (password_verify($password, $hashed_password)) {
            // Password is correct, set session
            $_SESSION['user'] = $email;
            session_regenerate_id(true); // Prevent session fixation
            header("Location: index.html");
            exit();
        } else {
            $error = 'Incorrect password.';
        }
    } else {
        $error = 'Email not found.';
    }

    $stmt->close();
    $conn->close();

    // Store the error message in the session
    $_SESSION['error'] = $error;
    header("Location: login.php"); // Redirect back to the login page
    exit();
}
else {
    http_response_code(405);
    echo "Method Not Allowed";
}
?>

