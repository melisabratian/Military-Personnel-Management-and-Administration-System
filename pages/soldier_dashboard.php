<?php
session_start();

if (!isset($_SESSION['user_id']) || !str_starts_with($_SESSION['user_id'], '3')) {
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


$task_query = "SELECT * FROM tasks WHERE assigned_to = ?";
$task_stmt = $conn->prepare($task_query);
$task_stmt->bind_param("s", $userID);
$task_stmt->execute();
$tasks = $task_stmt->get_result();

$leave_query = "SELECT * FROM history_leave WHERE user_ID = ?";
$leave_stmt = $conn->prepare($leave_query);
$leave_stmt->bind_param("s", $userID);
$leave_stmt->execute();
$leaves = $leave_stmt->get_result();


$equipment_query = "SELECT * FROM equipment WHERE assigned_to = ?";
$eq_stmt = $conn->prepare($equipment_query);
$eq_stmt->bind_param("s", $userID);
$eq_stmt->execute();
$equipment = $eq_stmt->get_result();


$active_leave_id = null;
$leave_sql = "SELECT ID FROM leave_requests WHERE user_ID = ? AND status = 'approved' AND CURDATE() BETWEEN start_date AND end_date AND equipment_returned = 'no'";
$leave_stmt2 = $conn->prepare($leave_sql);
$leave_stmt2->bind_param("s", $userID);
$leave_stmt2->execute();
$leave_result = $leave_stmt2->get_result();
if ($leave_result->num_rows > 0) {
    $leave_row = $leave_result->fetch_assoc();
    $active_leave_id = $leave_row['ID'];
}

$eq_check_sql = "SELECT equipment_ID FROM equipment_management WHERE user_ID = ? AND status = 'assigned'";
$eq_check_stmt = $conn->prepare($eq_check_sql);
$eq_check_stmt->bind_param("s", $userID);
$eq_check_stmt->execute();
$eq_check_result = $eq_check_stmt->get_result();
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Soldier Dashboard</title>
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
        .overlay { background-color: rgba(0, 0, 0, 0.6); min-height: 100vh; padding-bottom: 30px; }
        .logo-title { text-align: center; padding-top: 20px; }
        .logo-title img { height: 100px; }
        .logo-title h1 { font-size: 2.5rem; margin-top: 15px; }
        .logout-btn { position: absolute; top: 20px; right: 30px; }
        .subtitle {
            margin-top: 50px;
            margin-bottom: 15px;
            font-size: 1.5rem;
            font-weight: bold;
            border-bottom: 1px solid white;
            padding-bottom: 5px;
        }
        .table { background-color: white; color: black; }
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
        <h2>Welcome, Soldier <?= htmlspecialchars($name); ?></h2>
        <p class="text-light"><strong>Today is:</strong> <?= $dateToday ?></p>
    </div>

    <div class="container">
        <div class="subtitle">📋 Assigned Tasks</div>
        <?php if (isset($_GET['success']) && $_GET['success'] === "task_done"): ?>
    <div class="alert alert-success text-dark">✅ Task marked as completed!</div>
<?php elseif (isset($_GET['error']) && $_GET['error'] === "too_early"): ?>
    <div class="alert alert-warning text-dark">⏳ You can't complete a task before it starts.</div>
<?php elseif (isset($_GET['error']) && $_GET['error'] === "task_update_failed"): ?>
    <div class="alert alert-danger text-dark">❌ Failed to update task status.</div>
<?php elseif (isset($_GET['error']) && $_GET['error'] === "task_not_found"): ?>
    <div class="alert alert-danger text-dark">❌ Task not found or access denied.</div>
<?php endif; ?>


        <table class="table table-striped">
            <thead><tr><th>Task Name</th><th>Description</th><th>Start</th><th>End</th><th>Status</th></tr></thead>
            <tbody>
            <?php while ($task = $tasks->fetch_assoc()): ?>
                <tr>
                    <td><?= htmlspecialchars($task['task_name']) ?></td>
                    <td><?= htmlspecialchars($task['description']) ?></td>
                    <td><?= date("Y-m-d", strtotime($task['start_date'])) ?></td>
<td><?= date("Y-m-d", strtotime($task['end_date'])) ?></td>

                    <td>
    <?= htmlspecialchars($task['status']) ?>
    <?php if ($task['status'] !== 'completed'): ?>
        <form action="mark_task_done.php" method="POST" style="display:inline;">
            <input type="hidden" name="task_id" value="<?= $task['task_ID'] ?>">
            <button type="submit" class="btn btn-sm btn-success ms-2">✅ Mark as Done</button>
        </form>
    <?php endif; ?>
</td>

                </tr>
            <?php endwhile; ?>
            </tbody>
        </table>

<div class="subtitle">📆 Leave Requests History</div>
<?php if ($leaves->num_rows > 0): ?>
    <table class="table table-striped">
        <thead>
            <tr>
                <th>From</th><th>To</th><th>Reason</th><th>Status</th><th>Equipment Returned</th>
            </tr>
        </thead>
        <tbody>
        <?php while ($leave = $leaves->fetch_assoc()): ?>
            <tr>
                <td><?= htmlspecialchars($leave['start_date']) ?></td>
                <td><?= htmlspecialchars($leave['end_date']) ?></td>
                <td><?= htmlspecialchars($leave['reason']) ?></td>
                <td><?= htmlspecialchars($leave['status']) ?></td>
                <td><?= ($leave['equipment_returned'] ?? 'no') === 'yes' ? 'Yes' : 'No' ?></td>
            </tr>
        <?php endwhile; ?>
        </tbody>
    </table>
<?php else: ?>
    <p class="text-light">No leave requests found.</p>
<?php endif; ?>


<div class="subtitle">📝 Submit a Leave Request</div>

<form id="leaveRequestForm" action="submit_leave_request.php" method="POST" class="mb-5">
    <div class="row">
        <div class="col-md-6 mb-3">
            <label for="start_date" class="form-label">Start Date</label>
            <input type="date" name="start_date" id="start_date" class="form-control" required>
        </div>
        <div class="col-md-6 mb-3">
            <label for="end_date" class="form-label">End Date</label>
            <input type="date" name="end_date" id="end_date" class="form-control" required>
        </div>
    </div>
    <div class="mb-3">
        <label for="reason" class="form-label">Reason</label>
        <textarea name="reason" id="reason" class="form-control" required></textarea>
    </div>
    <button type="submit" class="btn btn-primary">Submit Request</button>
</form>

<?php if (isset($_GET['success']) && $_GET['success'] === "leave_submitted"): ?>
    <div class="alert alert-success text-dark text-center">✅ Leave request submitted successfully!</div>
<?php elseif (isset($_GET['error']) && $_GET['error'] === "invalid_dates"): ?>
    <div class="alert alert-danger text-dark text-center">⚠️ End date must be after start date.</div>
<?php elseif (isset($_GET['error']) && $_GET['error'] === "submit_failed"): ?>
    <div class="alert alert-danger text-dark text-center">❌ Failed to submit leave request. Try again later.</div>
<?php endif; ?>


<div class="subtitle">🔫 Assigned Equipment</div>

<?php
$eq_stmt = $conn->prepare("SELECT * FROM view_assigned_equipment WHERE user_ID = ?");
$eq_stmt->bind_param("s", $userID);
$eq_stmt->execute();
$equipment = $eq_stmt->get_result();
?>

<table class="table table-striped">
    <thead>
        <tr>
            <th>Name</th>
            <th>Category</th>
            <th>Model</th>
            <th>Serial Number</th>
            <th>Status</th>
        </tr>
    </thead>
    <tbody>
        <?php while ($eq = $equipment->fetch_assoc()): ?>
            <tr>
                <td><?= htmlspecialchars($eq['equipment_name']) ?></td>
                <td><?= htmlspecialchars($eq['category']) ?></td>
                <td><?= htmlspecialchars($eq['model']) ?></td>
                <td><?= htmlspecialchars($eq['serial_number']) ?></td>
                <td><?= htmlspecialchars($eq['status']) ?></td>
            </tr>
        <?php endwhile; ?>
    </tbody>
</table>

<?php if ($active_leave_id && $eq_check_result->num_rows > 0): ?>
    <div class="mt-4 text-center">
        <form action="equipment_return.php" method="POST">
            <input type="hidden" name="leave_request_id" value="<?= $active_leave_id ?>">
            <button type="submit" class="btn btn-warning btn-lg">
                🛡 Return Assigned Equipment
            </button>
        </form>
    </div>
<?php endif; ?>


</div>
</body>
</html>

<?php $conn->close(); ?>
