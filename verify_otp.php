<?php
session_start();
error_reporting(E_ALL);
ini_set('display_errors', 1);

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $entered_otp = $_POST['otp'];

    if (isset($_SESSION['otp'])) {
        if ($entered_otp == $_SESSION['otp']) {
            
            header("Location: index3.html");
            exit();
        } else {
            $error = "Invalid or expired OTP.";
        }
    } else {
        $error = "OTP session expired or not set.";
    }
}
?>

<!DOCTYPE html>
<html>
<head>
    <title>Verify OTP</title>
</head>
<body>
    <div class="container">
        <h2>Verify OTP</h2>
        <?php if (isset($error)) echo "<p style='color:red;'>$error</p>"; ?>
        <form action="verify_otp.php" method="POST">
            <input type="text" name="otp" placeholder="Enter the OTP" required>
            <input type="submit" value="Verify OTP">
        </form>
    </div>
</body>
</html>
