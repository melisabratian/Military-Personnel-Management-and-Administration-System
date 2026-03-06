<?php
session_start();

// Allow only officers
if (!isset($_SESSION['user_id']) || !str_starts_with($_SESSION['user_id'], '5')) {
    header("Location: login.php");
    exit();
}

$conn = new mysqli("localhost", "root", "", "military_unit");
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

// Get and sanitize inputs
$task_name = $_POST['task_name'];
$description = $_POST['description'];
$start_date = substr($_POST['start_date'], 0, 10); 
$end_date = substr($_POST['end_date'], 0, 10);
$assigned_to = $_POST['assigned_to'];

// Validate date order
if (strtotime($end_date) < strtotime($start_date)) {
    header("Location: officer_dashboard.php?error=task_dates");
    exit();
}

$status = "in progress";

$stmt = $conn->prepare("INSERT INTO tasks (task_name, description, start_date, end_date, assigned_to, status)
                        VALUES (?, ?, ?, ?, ?, ?)");
$stmt->bind_param("ssssss", $task_name, $description, $start_date, $end_date, $assigned_to, $status);

if ($stmt->execute()) {
    header("Location: officer_dashboard.php?success=task");
} else {
    echo "Error: " . $stmt->error;
}

$stmt->close();
$conn->close();
?>

