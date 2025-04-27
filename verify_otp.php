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

.container input[type="text"],
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

.container input[type="text"]:focus {
    box-shadow: 0 0 10px rgba(0, 255, 255, 0.4);
}

.container input[type="submit"] {
    background: linear-gradient(90deg, #00d9ff, #7f5af0);
    color: #000;
    font-weight: 600;
    letter-spacing: 1px;
    cursor: pointer;
    transition: 0.3s;
}

.container input[type="submit"]:hover {
    background: linear-gradient(90deg, #7f5af0, #00d9ff);
    box-shadow: 0 4px 12px rgba(166, 108, 255, 0.3);
    opacity: 0.9;
}

.container input[type="submit"]::first-letter {
    text-transform: uppercase;
}

.error-message {
    color: red;
    margin-bottom: 15px;
}
</style>
</head>
<body>
    <div class="container">
        <h2>Verify OTP</h2>
        <?php if (isset($error)) echo "<p style='color:red;'>$error</p>"; ?>
        <form action="verify_otp.php" method="POST">
            <input type="text" name="otp" placeholder=" Enter the OTP" required>
            <input type="submit" value="Verify OTP">
        </form>
    </div>
</body>
</html>
