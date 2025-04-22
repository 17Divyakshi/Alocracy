<?php
session_start();
error_reporting(E_ALL);
ini_set('display_errors', 1);

if (isset($_POST['otp'])) {
    $entered_otp = $_POST['otp'];

    
    if (isset($_SESSION['otp'])) {
        
        if ($entered_otp == $_SESSION['otp']) {
            echo "OTP verified successfully!";
        } else {
            echo "Invalid or expired OTP.";
        }
    } else {
        echo "OTP session expired or not set.";
    }
}
?>

<!DOCTYPE html>
<html>
<head>
    <title>Verify OTP</title>
    <style>
   
    </style>
</head>
<body>
    <div class="container">
        <h2>Verify OTP</h2>
        <form action="verify_otp.php" method="POST">
            <input type="text" name="otp" placeholder="Enter the OTP" required>
            <input type="submit" value="Verify OTP">
        </form>
    </div>
</body>
</html>
