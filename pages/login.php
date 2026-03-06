<?php
session_start();

if (isset($_SESSION['user_id'])) {
    $id = $_SESSION['user_id'];

    if (str_starts_with($id, '5')) {
        header("Location: officer_dashboard.php");
    } elseif (str_starts_with($id, '3')) {
        header("Location: soldier_dashboard.php");
    } else {
        header("Location: ../index.php"); 
    }
    exit();
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Login - Military Unit</title>
    <link rel="stylesheet" href="../assets/css/bootstrap.min.css">
    <style>
        body {
            background-color: #f5f5f5;
        }
        .login-container {
            max-width: 400px;
            margin: 80px auto;
            background-color: white;
            border-radius: 10px;
            padding: 30px;
            box-shadow: 0px 0px 10px rgba(0,0,0,0.2);
        }
        .login-title {
            text-align: center;
            margin-bottom: 20px;
        }
    </style>
</head>
<body>

<div class="login-container">
    <h2 class="login-title">Military Login</h2>
    <form action="login_process.php" method="POST">
        <div class="mb-3">
            <label for="user_id" class="form-label">Military ID</label>
            <input type="text" name="user_id" id="user_id" class="form-control" required>
        </div>
        <div class="mb-3">
            <label for="password" class="form-label">Password</label>
            <input type="password" name="password" id="password" class="form-control" required>
        </div>
        <?php if (isset($_GET['error'])): ?>
            <div class="alert alert-danger"><?php echo htmlspecialchars($_GET['error']); ?></div>
        <?php endif; ?>
        <button type="submit" class="btn btn-primary w-100">Log In</button>
    </form>
</div>

</body>
</html>

