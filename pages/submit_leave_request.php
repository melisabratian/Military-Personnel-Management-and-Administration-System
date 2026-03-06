<?php
session_start();

if (!isset($_SESSION['user_id'])) {
    header("Location: login.php");
    exit();
}

$userID = $_SESSION['user_id'];
$start = $_POST['start_date'];
$end = $_POST['end_date'];
$reason = $_POST['reason'];
$submission_date = date('Y-m-d');

$conn = new mysqli("localhost", "root", "", "military_unit");
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

if (strtotime($end) < strtotime($start)) {
    header("Location: soldier_dashboard.php?error=invalid_dates");
    exit();
}

$stmt = $conn->prepare("INSERT INTO leave_requests (user_ID, start_date, end_date, reason, status, equipment_returned, submission_date)
VALUES (?, ?, ?, ?, 'pending', 'no', ?)");
$stmt->bind_param("sssss", $userID, $start, $end, $reason, $submission_date);

if ($stmt->execute()) {
    header("Location: soldier_dashboard.php?success=leave_submitted");
} else {
    header("Location: soldier_dashboard.php?error=submit_failed");
}

$stmt->close();
$conn->close();
