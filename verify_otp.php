<?php
session_start();
error_reporting(E_ALL);
ini_set('display_errors', 1);

// If form is submitted to verify OTP
if (isset($_POST['otp'])) {
    $entered_otp = $_POST['otp'];

    // Ensure session OTP is set before comparing
    if (isset($_SESSION['otp'])) {
        // Check if entered OTP matches session OTP
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
        /* Styling here (same as before) */
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
