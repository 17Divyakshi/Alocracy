<?php
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $name = $_POST['name'];
    $city = $_POST['city'];
    $state = $_POST['state'];
    $aadhar = $_POST['aadhar'];

    $file = fopen("voters.csv", "a");
    fputcsv($file, [$name, $city, $state, $aadhar], ",", '"', "\\");
    fclose($file);

    header("Location: authenticate.html");
    exit();
}
