<?php
session_start();

if (!isset($_SESSION['user_id']) || !str_starts_with($_SESSION['user_id'], '5')) {
    header("Location: login.php");
    exit();
}

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $applicationID = $_POST['application_id'] ?? null;
    $action = $_POST['action'] ?? null;

    if (!$applicationID || !in_array($action, ['accept', 'reject'])) {
        header("Location: officer_dashboard.php?error=invalid_input");
        exit();
    }

    $conn = new mysqli("localhost", "root", "", "military_unit");
    if ($conn->connect_error) {
        die("Connection failed: " . $conn->connect_error);
    }

    $status = $action === 'accept' ? 'accepted' : 'rejected';
    $reviewed_by = $_SESSION['user_id'];

    $email = null;
    if ($action === 'accept') {
        $email_stmt = $conn->prepare("SELECT email FROM civilian_applications WHERE application_ID = ?");
        $email_stmt->bind_param("i", $applicationID);
        $email_stmt->execute();
        $email_result = $email_stmt->get_result();
        if ($email_result->num_rows > 0) {
            $email = $email_result->fetch_assoc()['email'];
        }
        $email_stmt->close();
    }

    $stmt = $conn->prepare("UPDATE civilian_applications SET status = ?, reviewed_by = ? WHERE application_ID = ?");
    $stmt->bind_param("sii", $status, $reviewed_by, $applicationID);

    if ($stmt->execute()) {
        if ($status === 'accepted' && $email) {
            header("Location: officer_dashboard.php?email=" . urlencode($email));
        } else {
            header("Location: officer_dashboard.php?updated=true");
        }
    } else {
        header("Location: officer_dashboard.php?error=update_failed");
    }

    $stmt->close();
    $conn->close();
} else {
    header("Location: officer_dashboard.php");
    exit();
}

