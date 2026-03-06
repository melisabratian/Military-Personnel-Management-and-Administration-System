
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport"
          content="width=device-width, initial-scale=1.0">
    <title>Main Page</title>
    <link rel="stylesheet" href="assets/css/bootstrap.min.css">
    <link rel="stylesheet" href="assets/css/style.css">
    <style>
        .video-container {
            width: 100vw;
            height: auto;
            overflow: hidden;
            margin: 0;
            padding: 0;
        }

        video {
            width: 100%;
            height: auto;
            display: block;
        }

        .video-text-overlay {
            position: absolute;
            top: 50%;
            left: 50%;
            transform: translate(-50%, -50%);
            color: white;
            font-size: 3rem;
            font-weight: bold;
            text-shadow: 2px 2px 8px #000;
        }
    </style>
</head>
<body>

<?php include 'header.php'; ?>

<div class="video-container position-relative">
    <video autoplay loop muted playsinline>
        <source src="images/military_intro.mp4" type="video/mp4">
        Your browser does not support the video tag.
    </video>
    <div class="video-text-overlay">
    <div>Welcome to the Military Unit</div>
    <div style="text-align: center;">Website</div>
</div>

</div>

<?php include 'footer.php'; ?>

</body>
</html>






