<?php
session_start();


if (!isset($_SESSION['user_id'])) {
    header("Location: login.php");
    exit();
}

$user_id = $_SESSION['user_id'];


if (str_starts_with($user_id, '3')) {
    
    header("Location: soldier_dashboard.php");
    exit();
} elseif (str_starts_with($user_id, '5')) {
    
    header("Location: officer_dashboard.php");
    exit();
} else {
    
    echo "<h2 style='text-align: center; margin-top: 50px;'>⚠️ Access denied. Unknown user type.</h2>";
    echo "<p style='text-align: center;'><a href='logout.php'>Log out</a></p>";
}
?>
