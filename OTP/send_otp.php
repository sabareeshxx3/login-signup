<?php
session_start();
include("dbconnect.php");
include("email.php");

$email=$_POST["user_email"];
$sql="Select * from users where user_email='$email'";
$rs=mysqli_query($con,$sql)or die(mysqli_error($con));
if(mysqli_num_rows($rs)>0){
  $_SESSION['email']=$email;
  $otp=rand(11111,99999);
   send_otp($email,"PHP OTP LOGIN",$otp);
  $sql="update users set user_otp='$otp' where user_email='$email'";
$rs=mysqli_query($con,$sql)or die(mysqli_error($con));
header("location:verify.php?msg=Plz check Your Email For OTP and Verify");

}
else{
    header("location:index.php?msg=Email id is Invalid....plz check Again!!!");
}
?>