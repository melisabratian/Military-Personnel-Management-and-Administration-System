<?php
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $full_name = $_POST['full_name'] ?? '';
    $email = $_POST['email'] ?? '';
    $phone_number = $_POST['phone_number'] ?? null;
    $cv_document = $_POST['cv_document'] ?? null;
    $application_date = date('Y-m-d');
    $status = 'pending';
    $reviewed_by = null; 


    if (empty($full_name) || empty($email)) {
        header("Location: military_career.php?error=missing_fields");
        exit();
    }


    $conn = new mysqli("localhost", "root", "", "military_unit");
    if ($conn->connect_error) {
        die("Connection failed: " . $conn->connect_error);
    }

    $stmt = $conn->prepare("INSERT INTO civilian_applications (full_name, email, phone_number, cv_document, application_date, status, reviewed_by) 
                            VALUES (?, ?, ?, ?, ?, ?, ?)");
    $stmt->bind_param("ssssssi", $full_name, $email, $phone_number, $cv_document, $application_date, $status, $reviewed_by);

    if ($stmt->execute()) {
        header("Location: military_career.php?success=true");
    } else {
        header("Location: military_career.php?error=submit_failed");
    }

    $stmt->close();
    $conn->close();
} else {
    header("Location: military_career.php");
    exit();
}
