<?php
error_reporting(E_ALL);
ini_set('display_errors', 1);

header("Access-Control-Allow-Origin: *");
header("Access-Control-Allow-Methods: POST");
header("Access-Control-Allow-Headers: Content-Type");

if ($_SERVER["REQUEST_METHOD"] !== "POST") {
    echo json_encode(["status" => "error", "message" => "Invalid request"]);
    exit;
}

if (!isset($_FILES["voterID"])) {
    echo json_encode(["status" => "error", "message" => "No file uploaded"]);
    exit;
}

$uploadDir = __DIR__ . "/uploads/";
if (!is_dir($uploadDir)) {
    mkdir($uploadDir, 0777, true);
}

$targetFile = $uploadDir . "voter_card.jpeg"; // Save as fixed name

if (move_uploaded_file($_FILES["voterID"]["tmp_name"], $targetFile)) {
    echo json_encode([
        "status" => "success",
        "message" => "Voter ID uploaded!",
        "filename" => "voter_card.jpeg"
    ]);
} else {
    echo json_encode([
        "status" => "error",
        "message" => "Failed to save uploaded file."
    ]);
}

