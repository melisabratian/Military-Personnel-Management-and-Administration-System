<?php
if (session_status() === PHP_SESSION_NONE) {
    session_start();
}
include("../Header.php");
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Military Career</title>
    <link rel="stylesheet" href="../assets/css/bootstrap.min.css">
    <style>
        body {
            background: url("../images/career_background.jpg") no-repeat center center fixed;
            background-size: cover;
            color: white;
        }

        .content-wrapper {
            background-color: rgba(255, 255, 255, 0.95);
            color: black;
            padding: 40px;
            margin: 40px auto;
            max-width: 1000px;
            border-radius: 15px;
            box-shadow: 0 0 20px rgba(0, 0, 0, 0.3);
        }

        .career-images {
            display: flex;
            justify-content: space-between;
            gap: 20px;
            margin-bottom: 30px;
        }

        .career-images img {
            width: 48%;
            height: auto;
            border: 5px solid white;
            border-radius: 10px;
            object-fit: cover;
        }

        .motivational-text {
            font-size: 1.2rem;
            text-align: center;
            margin-bottom: 30px;
        }

        video {
            width: 100%;
            border: 5px solid white;
            border-radius: 10px;
            margin-bottom: 30px;
        }

        .form-label {
            font-weight: bold;
        }
    </style>
</head>
<body>

<div class="content-wrapper">
    <h1 class="text-center mb-4">🎖 Military Careers Start Here</h1>

    
    <div class="career-images">
        <img src="../images/career1.png" alt="Career Image 1">
        <img src="../images/career2.jpg" alt="Career Image 2">
    </div>

    <div class="motivational-text">
        Step into a career where courage meets discipline. Whether in combat, logistics, or support, you play a vital role in safeguarding your country. The military offers structure, purpose, and pride in service.
    </div>
    <div class="container bg-light text-dark p-4 rounded mt-4" style="box-shadow: 0 0 10px rgba(0,0,0,0.2);">
<?php if (isset($_GET['success'])): ?>
  <div class="alert alert-success">Application submitted!</div>
<?php endif; ?>


    <h4 class="mb-3">📌 Minimum Application Requirements</h4>
    <ul style="line-height: 1.8;">
        <li>Must hold Romanian citizenship and have permanent residence in Romania.</li>
        <li>Must be between 18 years old (at the start of training) and 45 years old (at the end of training).</li>
        <li>Must not be a sole shareholder or involved in managing commercial organizations, except as provided by law. If applicable, must agree in writing to give up such positions upon admission.</li>
        <li>Must have completed at least the first two years of high school (minimum 10 grades).</li>
        <li>Must not be a member of any political party.</li>
        <li>Must have no criminal record.</li>
        <li>Must be medically fit.</li>
        <li>Must pass a psychological evaluation.</li>
        <li>For military roles requiring vehicle operation, must hold a valid driving license categories B and C.</li>
    </ul>

    <div class="text-center mt-4">
        <img src="../images/career3.jpg" alt="Military Careers" class="img-fluid rounded shadow" style="max-width: 100%; border: 2px solid #ccc;">
    </div>
</div>


    <h3 class="mb-3">📨 Civilian Application Form</h3>
    <form action="submit_application.php" method="POST">
        <div class="mb-3">
            <label for="full_name" class="form-label">Full Name</label>
            <input type="text" name="full_name" id="full_name" class="form-control" required>
        </div>

        <div class="mb-3">
            <label for="email" class="form-label">Email Address</label>
            <input type="email" name="email" id="email" class="form-control" required>
        </div>

        <div class="mb-3">
            <label for="phone_number" class="form-label">Phone Number </label>
            <input type="text" name="phone_number" id="phone_number" class="form-control">
        </div>

        <div class="mb-3">
            <label for="cv_document" class="form-label">Message or brief CV </label>
            <textarea name="cv_document" id="cv_document" class="form-control" rows="4"></textarea>
        </div>

        <p class="text-muted"><small>* Completing this form does not guarantee selection. If your application is shortlisted, you will receive an email invitation for an interview. You will be required to bring your CV at that time.</small></p>

        <button type="submit" class="btn btn-primary">Submit Application</button>
    </form>
</div>

</body>
</html>

<?php include("../Footer.php"); ?>
