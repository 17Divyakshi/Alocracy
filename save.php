<?php
session_start();

// Check if the user has already voted
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    // Get the Aadhar from the registration form
    $aadhar = $_POST['aadhar'];

    // Check if Aadhar already exists in votes.csv
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
        // If already voted, prevent registration and show a message
        echo "<h2 style='color: red; text-align: center;'>A vote has already been recorded with that Aadhar number.</h2>";
    } else {
        // If not voted, register the user
        $name = $_POST['name'];
        $city = $_POST['city'];
        $state = $_POST['state'];
        $dob = $_POST['dob'];

        // Save the registration data to a CSV file (voters.csv)
        $file = fopen("voters.csv", "a");
        fputcsv($file, [$name, $city, $state, $aadhar,$dob]);
        fclose($file);

        // Redirect to OTP verification page (or wherever you want)
        header("Location: send_otp.php");
        exit();
    }
}
?>

