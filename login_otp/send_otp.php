<?php
session_start();
include("dbconnect.php"); // Assuming this file contains database connection code
include("email.php"); // Assuming this file contains the send_otp() function

// Assuming form data is sent using POST method
if(isset($_POST["user_email"])) {
    $email = $_POST["user_email"];

    // Query to check if the user email already exists
    $sql_check_email = "SELECT * FROM users WHERE user_email = '$email'";
    $result_check_email = mysqli_query($con, $sql_check_email) or die(mysqli_error($con));

    if(mysqli_num_rows($result_check_email) == 0) {
        // Email does not exist in the database, so insert it
        $sql_insert_email = "INSERT INTO users (user_email) VALUES ('$email')";
        $result_insert_email = mysqli_query($con, $sql_insert_email) or die(mysqli_error($con));
        
        if(!$result_insert_email) {
            // Error occurred while inserting email
            header("location: index.php?msg=An error occurred. Please try again later.");
            exit();
        }
    }

    // Generate OTP
    $otp = rand(11111, 99999);
    
    // Send OTP
    send_otp($email, "PHP OTP LOGIN", $otp);

    // Update user_otp in the database
    $sql_update_otp = "UPDATE users SET user_otp='$otp' WHERE user_email='$email'";
    $result_update_otp = mysqli_query($con, $sql_update_otp) or die(mysqli_error($con));

    if($result_update_otp) {
        $_SESSION['email'] = $email;
        header("location: verify.php?msg=Please check your email for OTP and verify");
        exit();
    } else {
        // Error occurred while updating OTP
        header("location: index.php?msg=An error occurred. Please try again later.");
        exit();
    }
} else {
    // Redirect if user_email is not set
    header("location: index.php");
    exit();
}
?>
