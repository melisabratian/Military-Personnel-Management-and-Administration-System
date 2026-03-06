<?php
session_start();

if (!isset($_SESSION['user_id']) || !str_starts_with($_SESSION['user_id'], '3')) {
    header("Location: login.php");
    exit();
}

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $taskID = $_POST['task_id'];
    $userID = $_SESSION['user_id'];
    $today = date('Y-m-d');

    $conn = new mysqli("localhost", "root", "", "military_unit");
    if ($conn->connect_error) {
        die("Connection failed: " . $conn->connect_error);
    }

    // Get task info first
    $stmt = $conn->prepare("SELECT start_date FROM tasks WHERE task_ID = ? AND assigned_to = ?");
    $stmt->bind_param("is", $taskID, $userID);
    $stmt->execute();
    $result = $stmt->get_result();
    $task = $result->fetch_assoc();
    $stmt->close();

    if (!$task) {
        header("Location: soldier_dashboard.php?error=task_not_found");
        exit();
    }

    if (strtotime($today) < strtotime($task['start_date'])) {
        header("Location: soldier_dashboard.php?error=too_early");
        exit();
    }


    $update = $conn->prepare("UPDATE tasks SET status = 'completed' WHERE task_ID = ? AND assigned_to = ?");
    $update->bind_param("is", $taskID, $userID);

    if ($update->execute()) {
        header("Location: soldier_dashboard.php?success=task_done");
    } else {
        header("Location: soldier_dashboard.php?error=task_update_failed");
    }

    $update->close();
    $conn->close();
}
?>
