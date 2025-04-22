<?php
session_start();
if (!isset($_SESSION['aadhar'])) {
    header("Location: authenticate.html");
    exit();
}

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $party = $_POST['party'];
    $aadhar = $_SESSION['aadhar'];

    // Check if this Aadhar already voted
    $alreadyVoted = false;
    if (($handle = fopen("votes.csv", "r")) !== FALSE) {
        while (($data = fgetcsv($handle)) !== FALSE) {
            if ($data[0] == $aadhar) {
                $alreadyVoted = true;
                break;
            }
        }
        fclose($handle);
    }

    if ($alreadyVoted) {
        echo "<h2 style='font-family: Arial, sans-serif; color: red; text-align: center; margin-top: 20%;'>You have already voted!</h2>";
    } else {
        $vote_file = fopen("votes.csv", "a");
        fputcsv($vote_file, [$aadhar, $party]);
        fclose($vote_file);

        echo "<h2 style='font-family: Arial, sans-serif; color: green; text-align: center; margin-top: 20%;'>Thank you for voting!</h2>";
    }

    $_SESSION = [];
    session_destroy();
}
?>
