<?php
session_start();
error_reporting(E_ALL);
ini_set('display_errors', 1);

// Ensure that PHPMailer is loaded first
use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\Exception;
require 'vendor/autoload.php';

if (isset($_POST['email'])) {
    
    $email = $_POST['email'];
    $_SESSION['email'] = $email; 
    
    $otp = rand(100000, 999999);  

    $_SESSION['otp'] = $otp;  
    $_SESSION['otp_created_time'] = time(); 


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

body {
    margin: 0;
    padding: 0;
    height: 100vh;
    background: linear-gradient(120deg, #0f0c29, #24243e, #302b63);
    display: flex;
    justify-content: center;
    align-items: center;
    font-family: 'Poppins', sans-serif;
}

.container {
    background: rgba(26, 26, 46, 0.9);
    padding: 40px 30px;
    border-radius: 20px;
    box-shadow: 0 0 30px rgba(0, 255, 255, 0.1);
    text-align: center;
    width: 340px;
}

.container h2 {
    color: #00d9ff;
    margin-bottom: 30px;
    font-size: 26px;
    font-weight: 700;
    letter-spacing: 0.6px;
    font-size: 1.6rem;
    text-shadow: 0 1px 6px rgba(0, 255, 255, 0.2);
}

.container input[type="email"],
.container input[type="submit"] {
    width: 100%;
    padding: 15px 2px;
    margin: 10px 5px;
    margin-bottom: 25px;
    border: none;
    outline: none;
    border-radius: 10px;
    background: #1a1a2e;
    color: white;
    font-size: 17px;
    display: flex;
    align-items: center;
    box-shadow: 0 0 5px rgba(0, 255, 255, 0.1);
    transition: 0.3s;
}

.container input[type="email"]:focus {
    box-shadow: 0 0 10px rgba(0, 255, 255, 0.4);
}

.container input[type="submit"] {
    background:linear-gradient(90deg, #00d9ff, #7f5af0);
    color: #000;
    font-weight: 600;
    letter-spacing: 1px;
    cursor: pointer;
    transition: 0.3s;
}
input[type="submit"]:hover {
      background: linear-gradient(90deg, #7f5af0, #00d9ff);
      box-shadow: 0 4px 12px rgba(166, 108, 255, 0.3);
    }

.container input[type="submit"]:hover {
    opacity: 0.9;
}

.container input[type="submit"]::first-letter {
    text-transform: uppercase;
}
.note {
    color: #00d9ff;
    font-size: 14px;
    margin-bottom: 20px;
    text-shadow: 0 1px 5px rgba(0, 255, 255, 0.3);
    font-weight: 500;
    letter-spacing: 0.5px;
}

   
    </style>
</head>
<body>
    <div class="container">
        <h2>Send OTP</h2>
        <p class="note">Note: OTP will expire in 120 seconds.</p>

        <form action="send_otp.php" method="POST">
            <input type="email" name="email" placeholder=" Enter your email" required>
            <input type="submit" value="Send OTP">
        </form>
    </div>
</body>
</html>
