<?php
session_start();

if (!isset($_SESSION['user_id']) || !str_starts_with($_SESSION['user_id'], '5')) {
    header("Location: login.php");
    exit();
}

$equipment_mgmt_id = $_POST['equipment_id'] ?? null;
$user_id = $_POST['user_id'] ?? null;

if (!$equipment_mgmt_id || !$user_id) {
    header("Location: officer_dashboard.php?assigned=error");
    exit();
}

$conn = new mysqli("localhost", "root", "", "military_unit");
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

$update_mgmt = $conn->prepare("
    UPDATE equipment_management
    SET user_ID = ?, status = 'assigned', allocation_date = CURDATE(), return_date = NULL
    WHERE id = ?
");
$update_mgmt->bind_param("ii", $user_id, $equipment_mgmt_id);
$success_mgmt = $update_mgmt->execute();

$eq_id_query = $conn->prepare("SELECT equipment_ID FROM equipment_management WHERE id = ?");
$eq_id_query->bind_param("i", $equipment_mgmt_id);
$eq_id_query->execute();
$eq_id_result = $eq_id_query->get_result();
$eq_id = $eq_id_result->fetch_assoc()['equipment_ID'] ?? null;

if ($eq_id) {
    $update_eq = $conn->prepare("UPDATE equipment SET status = 'assigned', assigned_to = ? WHERE equipment_id = ?");
    $update_eq->bind_param("ii", $user_id, $eq_id);
    $update_eq->execute();
}

if ($success_mgmt) {
    header("Location: officer_dashboard.php?assigned=success");
} else {
    header("Location: officer_dashboard.php?assigned=error");
}

$conn->close();
?>
