<?php
error_reporting(E_ALL);
ini_set('display_errors', 1);

header("Access-Control-Allow-Origin: *");
header("Access-Control-Allow-Methods: POST");
header("Access-Control-Allow-Headers: Content-Type");
header("Content-Type: application/json"); // Ensure JSON response


// Debug: Check if files are received
if (!isset($_FILES["liveCapture"]) || !isset($_POST["voterFileName"])) {
    echo json_encode([
        "error" => "Missing required data",
        "received" => $_FILES,
        "post_data" => $_POST
    ]);
    exit;
}

// Move uploaded image to 'uploads' folder
$uploadDir = __DIR__ . "/uploads/";
if (!is_dir($uploadDir)) {
    mkdir($uploadDir, 0777, true);
}

$liveCapturePath = $uploadDir . "live_capture.jpeg";
if (!move_uploaded_file($_FILES["liveCapture"]["tmp_name"], $liveCapturePath)) {
    echo json_encode(["error" => "Failed to save live_capture"]);
    exit;
}

// Path of voter card image
$voterFilePath = $uploadDir . basename($_POST["voterFileName"]);

// Run Python script
$command = escapeshellcmd("python face_auth.py");
$output = shell_exec($command);

// Debug: Check raw Python output
if (!$output) {
    echo json_encode(["error" => "Python script returned empty response"]);
    exit;
}

// Debugging: Log Python output
file_put_contents("debug_log.txt", $output);

// Ensure Python output is valid JSON
$jsonOutput = json_decode($output, true);
if ($jsonOutput === null) {
    echo json_encode(["error" => "Invalid JSON from Python", "raw" => $output]);
    exit;
}

// Send response
echo json_encode($jsonOutput);
exit;
?>
