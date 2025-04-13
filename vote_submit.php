<?php
session_start();
if (!isset($_SESSION['aadhar'])) {
    header("Location: authenticate.html");
    exit();
}

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $party = $_POST['party'];
    $aadhar = $_SESSION['aadhar'];

    $vote_file = fopen("votes.csv", "a");
    fputcsv($vote_file, [$aadhar, $party]);
    fclose($vote_file);

    $_SESSION = [];
    session_destroy();

    echo "Thank you for voting!";
}
?>
