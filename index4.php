<?php
session_start();
error_reporting(E_ALL);
ini_set('display_errors', 1);

// Ensure that PHPMailer is loaded first
use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\Exception;
require 'vendor/autoload.php';

// If form is submitted to send OTP
if (isset($_POST['email']) && !isset($_POST['otp'])) {
    // Send OTP part
    $email = $_POST['email'];
    $_SESSION['email'] = $email;  
    
    $otp = rand(100000, 999999);  

    
    $_SESSION['otp'] = $otp;  

   
    $mail = new PHPMailer(true);
    try {
        $mail->isSMTP();
        $mail->Host = 'smtp.gmail.com';
        $mail->SMTPAuth = true;
        $mail->Username = 'vaibhavijha92@gmail.com';
        $mail->Password = 'ptsorhjsmpratbho';
        $mail->SMTPSecure = 'tls';
        $mail->Port = 587;

        $mail->setFrom('your_email@gmail.com', 'Voting System');
        $mail->addAddress($email);
        $mail->Subject = 'Your OTP Code';
        $mail->Body = 'Your OTP is: ' . $otp;
        $mail->send();
        
        echo "OTP sent successfully!<br>";
        echo "Please enter the OTP below to verify.";
    } catch (Exception $e) {
        echo "Failed to send OTP email. Mailer Error: {$mail->ErrorInfo}";
    }
}


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
    <title>OTP Verification</title>
    <style>
        body {
            font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif;
            background: linear-gradient(to right, #74ebd5, #ACB6E5);
            display: flex;
            justify-content: center;
            align-items: center;
            height: 100vh;
            margin: 0;
        }

        .container {
            background-color: white;
            padding: 40px;
            border-radius: 15px;
            box-shadow: 0 8px 16px rgba(0,0,0,0.2);
            width: 350px;
            text-align: center;
        }

        h2 {
            margin-bottom: 20px;
            color: #333;
        }

        input[type="email"],
        input[type="text"],
        input[type="submit"] {
            width: 100%;
            padding: 12px;
            margin: 10px 0;
            border: 1px solid #ccc;
            border-radius: 10px;
            font-size: 16px;
        }

        input[type="submit"] {
            background-color: #007BFF;
            color: white;
            border: none;
            transition: background-color 0.3s ease;
        }

        input[type="submit"]:hover {
            background-color: #0056b3;
            cursor: pointer;
        }

        .footer {
            margin-top: 15px;
            font-size: 13px;
            color: #555;
        }

        .section {
            margin-bottom: 30px;
        }
    </style>
</head>
<body>
    <div class="container">
        <h2>OTP Verification</h2>

        <!-- Section 1: Email Form -->
        <div class="section">
            <form action="" method="POST">
                <input type="email" name="email" placeholder="Enter your email" required>
                <input type="submit" value="Send OTP">
            </form>
        </div>

        <!-- Section 2: OTP Form (Only Show After OTP Sent) -->
        <?php if (isset($_SESSION['otp'])): ?>
        <div class="section">
            <form action="" method="POST">
                <input type="text" name="otp" placeholder="Enter the OTP" required>
                <input type="submit" value="Verify OTP">
            </form>
        </div>
        <?php endif; ?>

        <div class="footer">Your email is safe with us</div>
    </div>
</body>
</html>
