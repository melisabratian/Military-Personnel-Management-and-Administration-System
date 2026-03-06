<?php
if (session_status() === PHP_SESSION_NONE) {
    session_start();
}
$user = $_SESSION['user'] ?? 'guest';

$base = "/DB_Bratian_Melisa_30322_Project";
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Military Unit</title>

    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css">

    <style>
        .fixed-top-nav {
            position: fixed;
            top: 0;
            left: 0;
            width: 100%;
            z-index: 1030;
        }

        .header-title {
            font-family: 'Georgia', serif;
            font-size: 1.7rem;
            font-weight: bold;
            color: #343a40;
            line-height: 1.3;
        }

        .login-btn {
            font-weight: bold;
            background: url("<?= $base ?>/images/camo_texture.jpg") repeat;
            color: white;
            border: none;
        }

        .login-btn:hover {
            opacity: 0.9;
        }

        .nav-btn {
            font-size: 1.1rem;
        }

        @media (max-width: 768px) {
            .header-title {
                font-size: 1.2rem;
            }

            .nav-btn {
                font-size: 1rem !important;
                padding: 6px 12px !important;
            }
        }
    </style>
</head>
<body>

<div class="container-fluid bg-light py-3">
    <div class="row align-items-center mb-3">
        <div class="col-md-10 d-flex align-items-center">
            <a href="<?= $base ?>/index.php">
                <img src="<?= $base ?>/images/logo1.png" alt="Logo" style="height: 100px;">
            </a>
            <div>
                <h1 class="header-title mb-0">
                    22nd Mountain Infantry Battalion “Cireșoaia”<br>
                    <small style="font-size: 1.1rem; color: #555;">from Sfântu Gheorghe</small>
                </h1>
            </div>
        </div>

        <div class="col-md-2 text-end mt-2 mt-md-0">
            <?php if ($user === "guest"): ?>
                <a href="<?= $base ?>/pages/login.php" class="btn login-btn px-4 py-2 nav-btn">Log In</a>
            <?php else: ?>
                <div class="dropdown">
                    <button class="btn btn-success dropdown-toggle px-4 py-2 nav-btn" type="button" data-bs-toggle="dropdown" aria-expanded="false">
                        <?= htmlspecialchars($user); ?>
                    </button>
                    <ul class="dropdown-menu dropdown-menu-end">
                        <li><a class="dropdown-item" href="<?= $base ?>/pages/account_info.php">Account Info</a></li>
                        <li><a class="dropdown-item" href="<?= $base ?>/pages/logout.php">Log Out</a></li>
                    </ul>
                </div>
            <?php endif; ?>
        </div>
    </div>

    <div class="row align-items-center">
        <div class="col-12 d-flex justify-content-center gap-3 flex-wrap">
            <a href="<?= $base ?>/index.php" class="btn btn-outline-primary px-4 py-2 nav-btn">Home</a>
            <a href="<?= $base ?>/pages/about_us.php" class="btn btn-outline-primary px-4 py-2 nav-btn">About Us</a>
            <a href="<?= $base ?>/pages/military_career.php" class="btn btn-outline-primary px-4 py-2 nav-btn">Military Career</a>
            <a href="<?= $base ?>/pages/events.php" class="btn btn-outline-primary px-4 py-2 nav-btn">Events</a>
        </div>
    </div>
</div>

<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
