<?php
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $secretKey = "your-secret-key-here";
    $recaptchaResponse = $_POST['g-recaptcha-response'];

    $verifyURL = "https://www.google.com/recaptcha/api/siteverify?secret=$secretKey&response=$recaptchaResponse";
    $verify = file_get_contents($verifyURL);
    $responseData = json_decode($verify);

    if ($responseData->success) {
        if (isset($_FILES['voterIDUpload'])) {
            $file = $_FILES['voterIDUpload'];
            $filename = $file['name'];
            $tmpname = $file['tmp_name'];
            move_uploaded_file($tmpname, "uploads/" . $filename);
            echo "✅ Upload successful!";
        } else {
            echo "⚠️ No file uploaded.";
        }
    } else {
        echo "❌ CAPTCHA failed.";
    }
}
?>
