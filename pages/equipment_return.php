<?php
session_start();

if (!isset($_SESSION['user_id']) || !str_starts_with($_SESSION['user_id'], '3')) {
    header("Location: login.php");
    exit();
}

$user_id = $_SESSION['user_id'];
$leave_request_id = $_POST['leave_request_id'] ?? null;

$conn = new mysqli("localhost", "root", "", "military_unit");
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

$stmt1 = $conn->prepare("
    UPDATE equipment_management 
    SET status = 'returned', return_date = CURDATE()
    WHERE user_ID = ? AND status = 'assigned'
");
$stmt1->bind_param("s", $user_id);
$stmt1->execute();
$stmt1->close();

$stmt2 = $conn->prepare("
    UPDATE equipment 
    SET assigned_to = NULL, status = 'available'
    WHERE equipment_id IN (
        SELECT equipment_ID 
        FROM equipment_management 
        WHERE user_ID = ? AND status = 'returned'
    )
");
$stmt2->bind_param("s", $user_id);
$stmt2->execute();
$stmt2->close();

if ($leave_request_id) {
    $stmt3 = $conn->prepare("
        UPDATE leave_requests 
        SET equipment_returned = 'yes' 
        WHERE ID = ? AND user_ID = ?
    ");
    $stmt3->bind_param("ss", $leave_request_id, $user_id);
    $stmt3->execute();
    $stmt3->close();
}

$conn->close();

header("Location: soldier_dashboard.php?success=returned");
exit();
?>