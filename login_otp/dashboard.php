<?php
session_start();
include("dbconnect.php"); // Assuming this file contains database connection code
include("email.php"); // Assuming this file contains the send_otp() function

// Check if the user is logged in
if (!isset($_SESSION['email'])) {
    header("Location: index.php"); // Redirect to the login page if not logged in
    exit();
}

// Get the current date and time
$currentDateTime = date("Y-m-d H:i:s");

// Get the user's email from the session
$email = $_SESSION['email'];

// Query to insert the user's email and login time into the database
$sql = "INSERT INTO logins (user_email, login_time) VALUES ('$email', '$currentDateTime')";
$result = mysqli_query($con, $sql) or die(mysqli_error($con));

if ($result) {
    // Successfully inserted the login time into the database
} else {
    // Failed to insert the login time into the database
}

?>
<!doctype html>
<html lang="en">
<head>
    <title>Dashboard</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-T3c6CoIi6uLrA9TneNEoa7RxnatzjcDSCmG1MXxSR1GAsXEV/Dwwykc2MPK8M2HN" crossorigin="anonymous">
    <script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.11.8/dist/umd/popper.min.js" integrity="sha384-I7E8VVD/ismYTF4hNIPjVp/Zjvgyol6VFvRkX/vR+Vc4jQkC+hVqc2pM8ODewa9r" crossorigin="anonymous"></script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.min.js" integrity="sha384-BBtl+eGJRgqQAUMxJ7pMwbEyER4l1g+O15P+16Ep7Q9Q+zqX6gSbd85u4mG4QzX+" crossorigin="anonymous"></script> 
</head>
<body>
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.bundle.min.js" integrity="sha384-C6RzsynM9kWDrMNeT87bh95OGNyZPhcTNXj1NW7RuBCsyN/o0jlpcV8Qyq46cDfL" crossorigin="anonymous"></script>
<div class="container">  
    <h1>Welcome to the Dashboard</h1>
    <div class="alert alert-primary" role="alert">
        <?php
            if(isset($_REQUEST['msg'])) {
                echo $_REQUEST['msg'];
            }
        ?>
        <a href="logout.php?act=logout"><h4>Logout</h4></a>
    </div>
    <p>Login Time: <?php echo $currentDateTime; ?></p>
</div>
</body>
</html>
