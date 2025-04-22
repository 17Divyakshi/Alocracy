<?php
session_start();
error_reporting(E_ALL);
ini_set('display_errors', 1);

// Ensure that PHPMailer is loaded first
use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\Exception;
require 'vendor/autoload.php';

// If form is submitted to send OTP
if (isset($_POST['email'])) {
    // Send OTP part
    $email = $_POST['email'];
    $_SESSION['email'] = $email;  // Store email in session
    
    $otp = rand(100000, 999999);  // Generate OTP

    // Store OTP in session
    $_SESSION['otp'] = $otp;  

    // Send OTP via PHPMailer (use the code you already have)
    $mail = new PHPMailer(true);
    try {
        $mail->isSMTP();
        $mail->Host = 'smtp.gmail.com';
        $mail->SMTPAuth = true;
        $mail->Username = 'vaibhavijha92@gmail.com';  // Replace with your email
        $mail->Password = 'ptsorhjsmpratbho';  // Replace with your app password
        $mail->SMTPSecure = 'tls';
        $mail->Port = 587;

        $mail->setFrom('your_email@gmail.com', 'Voting System');
        $mail->addAddress($email);
        $mail->Subject = 'Your OTP Code';
        $mail->Body = 'Your OTP is: ' . $otp;
        $mail->send();
        
        
        header("Location: verify_otp.php");
        exit(); 
    } catch (Exception $e) {
        echo "Failed to send OTP email. Mailer Error: {$mail->ErrorInfo}";
    }
}
?>

<!DOCTYPE html>
<html>
<head>
    <title>Send OTP</title>
    <style>
        
    </style>
</head>
<body>
    <div class="container">
        <h2>Send OTP</h2>
        <form action="send_otp.php" method="POST">
            <input type="email" name="email" placeholder="Enter your email" required>
            <input type="submit" value="Send OTP">
        </form>
    </div>
</body>
</html>
