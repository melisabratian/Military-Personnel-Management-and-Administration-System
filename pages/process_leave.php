<?php
session_start();

if (!isset($_SESSION['user_id']) || !str_starts_with($_SESSION['user_id'], '5')) {
    header("Location: login.php");
    exit();
}

$conn = new mysqli("localhost", "root", "", "military_unit");
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

if (isset($_POST['request_id']) && isset($_POST['action'])) {
    $request_id = $_POST['request_id'];
    $action = $_POST['action']; // 'approve' or 'reject'

    $new_status = ($action === 'approve') ? 'approved' : 'rejected';

    $stmt = $conn->prepare("UPDATE leave_requests SET Status = ? WHERE ID = ?");
    $stmt->bind_param("si", $new_status, $request_id);

    if ($stmt->execute()) {
        header("Location: officer_dashboard.php?updated=1");
    } else {
        echo "Error: " . $stmt->error;
    }

    $stmt->close();
}

$conn->close();
?>
