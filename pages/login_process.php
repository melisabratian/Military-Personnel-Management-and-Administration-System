<?php
session_start();

$host = "localhost";
$db = "military_unit";
$user = "root";
$pass = "";

$user_id = $_POST['user_id'];
$password = $_POST['password'];

$conn = new mysqli($host, $user, $pass, $db);
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

$sql = "SELECT * FROM users WHERE ID = ?";
$stmt = $conn->prepare($sql);
$stmt->bind_param("s", $user_id);
$stmt->execute();
$result = $stmt->get_result();

if ($result->num_rows === 1) {
    $row = $result->fetch_assoc();

    if ($password === $row['Password']) {
        $_SESSION['user_id'] = $row['ID'];
        $_SESSION['user'] = $row['Name']; 
        $_SESSION['name'] = $row['Name'] . ' ' . $row['Surname'];
        $_SESSION['rank'] = $row['Rank'];
        $_SESSION['position'] = $row['Position'];

        // Redirecționare în funcție de ID
        if (str_starts_with($row['ID'], '5')) {
            header("Location: officer_dashboard.php");
        } elseif (str_starts_with($row['ID'], '3')) {
            header("Location: soldier_dashboard.php");
        } else {
            header("Location: login.php?error=Unknown role.");
        }
    } else {
        header("Location: login.php?error=Incorrect password");
    }
} else {
    header("Location: login.php?error=User ID not found");
}

$conn->close();
