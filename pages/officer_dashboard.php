<?php

session_start();

if (!isset($_SESSION['user_id']) || !str_starts_with($_SESSION['user_id'], '5')) {
    header("Location: login.php");
    exit();
}

$userID = $_SESSION['user_id'];
$name = $_SESSION['name'];
$dateToday = date('l, d F Y');

$conn = new mysqli("localhost", "root", "", "military_unit");
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

$app_sql = "SELECT * FROM civilian_applications WHERE Status = 'pending'";
$app_result = $conn->query($app_sql);

$task_result = $conn->query("SELECT * FROM view_upcoming_tasks");

$leave_sql = "SELECT l.ID, l.User_ID, l.Reason, l.Start_Date, l.End_Date, l.Status FROM leave_requests l WHERE l.Status = 'pending'";
$leave_result = $conn->query($leave_sql);

$available_sql = "
    SELECT ID, Name, Surname, Rank, Position
    FROM users 
    WHERE ID LIKE '3%' AND ID NOT IN (
        SELECT User_ID FROM leave_requests 
        WHERE Status = 'approved' AND CURDATE() BETWEEN Start_Date AND End_Date
    )
";
$available_result = $conn->query($available_sql);

$on_leave_result = $conn->query("SELECT * FROM view_current_leave");      

$equipment_sql = "
    SELECT 
        em.id AS management_id,
        e.equipment_name,
        e.category,
        e.model,
        e.serial_number,
        em.status,
        u.Name AS user_name,
        u.Surname AS user_surname
    FROM equipment_management em
    JOIN equipment e ON em.equipment_ID = e.equipment_id
    LEFT JOIN users u ON em.user_ID = u.ID
    ORDER BY em.status DESC, e.equipment_name ASC
";

$equipment_result = $conn->query($equipment_sql);

$count_sql = "
    SELECT COUNT(*) AS total_available
    FROM users 
    WHERE ID LIKE '3%' AND ID NOT IN (
        SELECT User_ID FROM leave_requests 
        WHERE Status = 'approved' AND CURDATE() BETWEEN Start_Date AND End_Date
    )
";
$count_result = $conn->query($count_sql);
$total_available = $count_result->fetch_assoc()['total_available'];
?>




<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Officer Dashboard</title>
    <link rel="stylesheet" href="../assets/css/bootstrap.min.css">
    <style>
        body {
            background-image: url("../images/login.jpg");
            background-size: cover;
            background-repeat: no-repeat;
            background-position: center;
            background-attachment: fixed;
            color: white;
        }

        .overlay {
            background-color: rgba(0, 0, 0, 0.6);
            min-height: 100vh;
            padding-bottom: 30px;
        }

        .logo-title {
            text-align: center;
            padding-top: 20px;
        }

        .logo-title img {
            height: 100px;
        }

        .logo-title h1 {
            font-size: 2.5rem;
            margin-top: 15px;
        }

        .logout-btn {
            position: absolute;
            top: 20px;
            right: 30px;
        }

        .subtitle {
            margin-top: 50px;
            margin-bottom: 15px;
            font-size: 1.5rem;
            font-weight: bold;
            border-bottom: 1px solid white;
            padding-bottom: 5px;
        }

        .table {
            background-color: white;
            color: black;
        }
    </style>
</head>
<body>
<div class="overlay">
    <div class="logout-btn">
        <a href="logout.php" class="btn btn-success btn-lg">Log Out</a>
    </div>

    <div class="logo-title">
        <img src="../images/logo1.png" alt="Logo">
        <h1>22nd Mountain Infantry Battalion Cireșoaia</h1>
        <p class="text-light">Sfântu Gheorghe</p>
    </div>

    <div class="container text-center mt-4">
        <h2>Welcome, Officer <?= htmlspecialchars($name); ?></h2>
        <p class="text-light"><strong>Today is:</strong> <?= $dateToday ?></p>
    </div>

    <div class="container">
<?php if (isset($_GET['assigned']) && $_GET['assigned'] === "success"): ?>
    <div class="alert alert-success text-dark">✅ Equipment assigned successfully!</div>
<?php elseif (isset($_GET['assigned']) && $_GET['assigned'] === "error"): ?>
    <div class="alert alert-danger text-dark">❌ Failed to assign equipment. Try again.</div>
<?php endif; ?>

        <?php if (isset($_GET['updated'])): ?>
            <div class="alert alert-success text-dark">Leave request status updated successfully.</div>
        <?php elseif (isset($_GET['success']) && $_GET['success'] == "task"): ?>
            <div class="alert alert-success text-dark">✅ Task assigned successfully!</div>
        <?php elseif (isset($_GET['error']) && $_GET['error'] === "task_dates"): ?>
            <div class="alert alert-danger text-dark">⚠️ End date cannot be before start date.</div>
        <?php endif; ?>

<div class="subtitle">📨 New Civilian Applications (<?= $app_result->num_rows ?>)</div>

<?php if (isset($_GET['email'])): ?>
    <div style="background-color: white; color: black; padding: 20px; margin-top: 20px; text-align: center; border: 2px solid #333; border-radius: 10px;">
        <h3 style="font-size: 1.8rem;">✅ Application Accepted</h3>
        <p style="font-size: 1.4rem; margin-bottom: 0;">You can now contact the applicant at:</p>
        <a href="https://mail.yahoo.com/compose?to=<?= urlencode($_GET['email']) ?>" 
           target="_blank" 
           style="font-size: 1.5rem; font-weight: bold; display: inline-block; margin-top: 10px;">
           <?= htmlspecialchars($_GET['email']) ?>
        </a>
    </div>
<?php elseif (isset($_GET['updated'])): ?>
    <div class="alert alert-info text-dark text-center" style="background-color: white; border: 2px solid #ccc;">
        Application status updated successfully.
    </div>
<?php endif; ?>

<table class="table table-striped">
    <thead>
        <tr>
            <th>Name</th>
            <th>Email</th>
            <th>Phone</th>
            <th>Message/CV</th>
            <th>Actions</th>
        </tr>
    </thead>
    <tbody>
    <?php while ($row = $app_result->fetch_assoc()): ?>
        <tr>
            <td><?= htmlspecialchars($row['full_name']) ?></td>
            <td><?= htmlspecialchars($row['email']) ?></td>
            <td><?= htmlspecialchars($row['phone_number'] ?? '-') ?></td>
            <td><?= htmlspecialchars($row['cv_document'] ?? 'N/A') ?></td>
            <td>
                <form action="process_application.php" method="POST" class="d-inline">
                    <input type="hidden" name="application_id" value="<?= $row['application_ID'] ?>">
                    <input type="hidden" name="email" value="<?= $row['email'] ?>">
                    <button name="action" value="accept" class="btn btn-success btn-sm">✅ Approve</button>
                </form>
                <form action="process_application.php" method="POST" class="d-inline ms-2">
                    <input type="hidden" name="application_id" value="<?= $row['application_ID'] ?>">
                    <button name="action" value="reject" class="btn btn-danger btn-sm">❌ Reject</button>
                </form>
            </td>
        </tr>
    <?php endwhile; ?>
    </tbody>
</table>




        <div class="subtitle">📋 Task Assignments (<?= $task_result->num_rows ?>)</div>
        <table class="table table-striped">
            <thead><tr><th>Name</th><th>Task</th><th>Description</th><th>Status</th></tr></thead>
            <tbody>
            <?php while ($row = $task_result->fetch_assoc()): ?>
                <tr>
                    <td><?= $row['Name'] . ' ' . $row['Surname'] ?></td>
                    <td><?= $row['task_name'] ?></td>
                    <td><?= $row['description'] ?></td>
                    <td><?= $row['status'] ?></td>
                </tr>
            <?php endwhile; ?>
            </tbody>
        </table>

        <div class="subtitle">📆 Pending Leave Requests (<?= $leave_result->num_rows ?>)</div>

<?php if ($leave_result->num_rows > 0): ?>
    <table class="table table-striped table-bordered align-middle">
        <thead class="table-dark">
            <tr>
                <th>Soldier ID</th>
                <th>Reason</th>
                <th>From</th>
                <th>To</th>
                <th>Status</th>
                <th>Actions</th>
            </tr>
        </thead>
        <tbody>
        <?php while ($row = $leave_result->fetch_assoc()): ?>
            <tr>
                <td><?= htmlspecialchars($row['User_ID']) ?></td>
                <td><?= htmlspecialchars($row['Reason']) ?></td>
                <td><?= htmlspecialchars($row['Start_Date']) ?></td>
                <td><?= htmlspecialchars($row['End_Date']) ?></td>
                <td>
                    <span class="badge bg-warning text-dark"><?= htmlspecialchars($row['Status']) ?></span>
                </td>
                <td>
                    <form action="process_leave.php" method="POST" class="d-inline">
                        <input type="hidden" name="request_id" value="<?= $row['ID'] ?>">
                        <button name="action" value="approve" class="btn btn-success btn-sm">
                            ✅ Approve
                        </button>
                    </form>
                    <form action="process_leave.php" method="POST" class="d-inline ms-2">
                        <input type="hidden" name="request_id" value="<?= $row['ID'] ?>">
                        <button name="action" value="reject" class="btn btn-danger btn-sm">
                            ❌ Reject
                        </button>
                    </form>
                </td>
            </tr>
        <?php endwhile; ?>
        </tbody>
    </table>
<?php else: ?>
    <div class="alert alert-info text-center text-dark">
        📭 No pending leave requests at the moment.
    </div>
<?php endif; ?>


        <div class="subtitle">🧑‍✈️ Soldiers Available in the Unit (<?= $total_available ?>)</div>
        <table class="table table-striped">
            <thead><tr><th>Name</th><th>Rank</th><th>Position</th></tr></thead>
            <tbody>
            <?php while ($row = $available_result->fetch_assoc()): ?>
                <tr>
                    <td><?= $row['Name'] . ' ' . $row['Surname'] ?></td>
                    <td><?= $row['Rank'] ?></td>
                    <td><?= $row['Position'] ?></td>
                </tr>
            <?php endwhile; ?>
            </tbody>
        </table>

        <div class="subtitle">🛌 Soldiers Currently on Leave (<?= $on_leave_result->num_rows ?>)</div>
<table class="table table-striped">
    <thead><tr><th>Name</th><th>From</th><th>To</th></tr></thead>
    <tbody>
    <?php while ($row = $on_leave_result->fetch_assoc()): ?>
        <tr>
            <td><?= htmlspecialchars($row['Name'] . ' ' . $row['Surname']) ?></td>
            <td><?= htmlspecialchars($row['Start_Date']) ?></td>
            <td><?= htmlspecialchars($row['End_Date']) ?></td>
        </tr>
    <?php endwhile; ?>
    </tbody>
</table>

        <div class="subtitle">➕ Assign a New Task</div>
        <form action="assign_task.php" method="POST" class="mb-5">
            <div class="mb-3">
                <label for="task_name" class="form-label">Task Name</label>
                <input type="text" name="task_name" id="task_name" class="form-control" required>
            </div>

            <div class="mb-3">
                <label for="description" class="form-label">Description</label>
                <textarea name="description" id="description" class="form-control" required></textarea>
            </div>

            <div class="row">
    <div class="col-md-6 mb-3">
        <label for="start_date" class="form-label">Start Date</label>
        <input type="date" name="start_date" class="form-control" required>
    </div>
    <div class="col-md-6 mb-3">
        <label for="end_date" class="form-label">End Date</label>
        <input type="date" name="end_date" class="form-control" required>
    </div>
</div>


            <div class="mb-3">
                <label for="assigned_to" class="form-label">Assign To</label>
                <select name="assigned_to" class="form-select" required>
                    <option value="" disabled selected>Select a soldier</option>
                    <?php
                    $available_result = $conn->query($available_sql);
                    while ($user = $available_result->fetch_assoc()):
                    ?>
                        <option value="<?= $user['ID'] ?>">
                            <?= $user['Name'] . ' ' . $user['Surname'] ?> (<?= $user['ID'] ?>)
                        </option>
                    <?php endwhile; ?>
                </select>
            </div>

            <button type="submit" class="btn btn-warning">Assign Task</button>
        </form>
    </div>



<div class="subtitle">🔫 Equipment Overview (<?= $equipment_result->num_rows ?>)</div>

<table class="table table-striped">
    <thead>
        <tr>
            <th>Equipment Name</th>
            <th>Category</th>
            <th>Model</th>
            <th>Serial</th>
            <th>Status</th>
            <th>Assigned To</th>
        </tr>
    </thead>
    <tbody>
        <?php while ($row = $equipment_result->fetch_assoc()): ?>
            <tr>
                <td><?= htmlspecialchars($row['equipment_name']) ?></td>
                <td><?= htmlspecialchars($row['category']) ?></td>
                <td><?= htmlspecialchars($row['model']) ?></td>
                <td><?= htmlspecialchars($row['serial_number']) ?></td>
                <td>
                    <span class="badge bg-<?= $row['status'] === 'assigned' ? 'warning' : ($row['status'] === 'available' ? 'success' : 'secondary') ?>">
                        <?= htmlspecialchars($row['status']) ?>
                    </span>
                </td>
                <td>
                    <?= $row['user_name'] ? htmlspecialchars($row['user_name'] . ' ' . $row['user_surname']) : '<i>Unassigned</i>' ?>
                </td>
            </tr>
        <?php endwhile; ?>
    </tbody>
</table>

<div class="subtitle">➕ Assign Equipment to Available Soldier</div>

<form action="assign_equipment.php" method="POST" class="mb-5">
    <div class="row">
        <div class="col-md-6 mb-3">
            <label for="equipment_id" class="form-label">Select Available Equipment</label>
            <select name="equipment_id" class="form-select" required>
                <option value="" disabled selected>Select available equipment</option>
                <?php
                $equip_query = "
                    SELECT em.id AS em_id, e.equipment_name, e.model
                    FROM equipment_management em
                    JOIN equipment e ON em.equipment_ID = e.equipment_id
                    WHERE em.status = 'available' AND em.user_ID IS NULL
                ";
                $equip_res = $conn->query($equip_query);
                while ($eq = $equip_res->fetch_assoc()):
                ?>
                    <option value="<?= $eq['em_id'] ?>">
                        <?= htmlspecialchars($eq['equipment_name']) . ' - ' . htmlspecialchars($eq['model']) ?>
                    </option>
                <?php endwhile; ?>
            </select>
        </div>

  
        <div class="col-md-6 mb-3">
            <label for="user_id" class="form-label">Select Soldier</label>
            <select name="user_id" class="form-select" required>
                <option value="" disabled selected>Select active soldier</option>
                <?php
                $soldiers_query = "
                    SELECT ID, Name, Surname FROM users 
                    WHERE ID LIKE '3%' AND ID NOT IN (
                        SELECT User_ID FROM leave_requests 
                        WHERE Status = 'approved' AND CURDATE() BETWEEN Start_Date AND End_Date
                    )
                ";
                $soldiers_result = $conn->query($soldiers_query);
                while ($sol = $soldiers_result->fetch_assoc()):
                ?>
                    <option value="<?= $sol['ID'] ?>">
                        <?= htmlspecialchars($sol['Name']) . ' ' . htmlspecialchars($sol['Surname']) ?> (<?= $sol['ID'] ?>)
                    </option>
                <?php endwhile; ?>
            </select>
        </div>
    </div>

    <div class="text-center">
        <button type="submit" class="btn btn-primary">Assign Equipment</button>
    </div>
</form>


</div>
</body>
</html>
<?php $conn->close(); ?>
