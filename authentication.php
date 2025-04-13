<?php
session_start();

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $aadhar = $_POST['aadhar'];
    $file = fopen("voters.csv", "r");

    while (($data = fgetcsv($file, 1000, ",", '"', "\\")) !== FALSE) {
        if ($data[3] == $aadhar) {
            $_SESSION['aadhar'] = $aadhar;
            fclose($file);
            header("Location: vote_form.php");
            exit();
        }
    }

    fclose($file);
    echo "Aadhar not found. Please register first.";
}
?>
