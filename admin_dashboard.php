<?php
session_start();
if(!isset($_SESSION['admin'])){
    header("Location: admin_login.php");
    exit;
}
include 'db.php';

// Handle actions
if(isset($_GET['action']) && isset($_GET['id'])){
    $id = (int)$_GET['id'];
    $action = $_GET['action'];

    if($action=='delete'){
        $conn->query("DELETE FROM submissions WHERE id=$id");
    } elseif(in_array($action, ['approved','rejected','pending'])){
        $conn->query("UPDATE submissions SET status='$action' WHERE id=$id");
    }
}

// Fetch submissions
$approved = $conn->query("SELECT * FROM submissions WHERE status='approved' ORDER BY submission_date DESC");
$rejected = $conn->query("SELECT * FROM submissions WHERE status='rejected' ORDER BY submission_date DESC");
$pending  = $conn->query("SELECT * FROM submissions WHERE status='pending' ORDER BY submission_date DESC");
?>

<!DOCTYPE html>
<html lang="en">
<head>
<meta charset="UTF-8">
<meta name="viewport" content="width=device-width, initial-scale=1.0">
<title>Admin Dashboard</title>
<link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet">
<link rel="stylesheet" href="style.css">
<style>
<?php include 'style.css'; ?>
.btn-action {margin-right:5px; margin-top:5px;}
</style>
</head>
<body>

<div class="container py-5" id="mainContent">
<h1 class="text-center mb-4 fw-bold" style="color:#bb86fc;">Admin Dashboard</h1>

<div class="text-center mb-4">
    <a href="logout.php" class="btn btn-glass fw-semibold">Logout</a>
</div>

<!-- Pending -->
<div class="glass-box mt-4">
<h3 class="fw-bold" style="color:#ffc107;">Pending Submissions</h3>
<div class="row g-3 mt-2">
<?php while($row = $pending->fetch_assoc()): ?>
<div class="col-md-6">
<div class="glass-box p-3">
    <h6 class="fw-bold"><?= $row['project_title'] ?></h6>
    <p class="mb-1"><strong>Submitted By:</strong> <?= $row['submitted_by'] ?></p>
    <p class="mb-1"><strong>Roll Numbers:</strong> <?= $row['roll_numbers'] ?></p>
    <p class="mb-1"><strong>Department:</strong> <?= $row['department'] ?></p>
    <p class="mb-1"><strong>Year:</strong> <?= $row['year'] ?></p>
    <p class="mb-1"><strong>Section:</strong> <?= $row['section'] ?></p>
    <p class="mb-0"><strong>Hardcopy:</strong> <?= $row['hardcopy']?'Yes':'No' ?></p>
    <div class="mt-3">
        <a href="?action=approved&id=<?= $row['id'] ?>" class="btn btn-glass btn-success btn-action">Approve</a>
        <a href="?action=rejected&id=<?= $row['id'] ?>" class="btn btn-glass btn-danger btn-action">Reject</a>
        <a href="?action=delete&id=<?= $row['id'] ?>" class="btn btn-glass btn-secondary btn-action">Delete</a>
    </div>
</div>
</div>
<?php endwhile; ?>
</div>
</div>

<!-- Approved -->
<div class="glass-box mt-4">
<h3 class="fw-bold" style="color:#4caf50;">Approved Submissions</h3>
<div class="row g-3 mt-2">
<?php while($row = $approved->fetch_assoc()): ?>
<div class="col-md-6">
<div class="glass-box p-3">
    <h6 class="fw-bold"><?= $row['project_title'] ?></h6>
    <p class="mb-1"><strong>Submitted By:</strong> <?= $row['submitted_by'] ?></p>
    <p class="mb-1"><strong>Roll Numbers:</strong> <?= $row['roll_numbers'] ?></p>
    <p class="mb-1"><strong>Department:</strong> <?= $row['department'] ?></p>
    <p class="mb-1"><strong>Year:</strong> <?= $row['year'] ?></p>
    <p class="mb-1"><strong>Section:</strong> <?= $row['section'] ?></p>
    <p class="mb-0"><strong>Hardcopy:</strong> <?= $row['hardcopy']?'Yes':'No' ?></p>
    <div class="mt-3">
        <a href="?action=rejected&id=<?= $row['id'] ?>" class="btn btn-glass btn-danger btn-action">Reject</a>
        <a href="?action=pending&id=<?= $row['id'] ?>" class="btn btn-glass btn-warning btn-action">Pending</a>
        <a href="?action=delete&id=<?= $row['id'] ?>" class="btn btn-glass btn-secondary btn-action">Delete</a>
    </div>
</div>
</div>
<?php endwhile; ?>
</div>
</div>

<!-- Rejected -->
<div class="glass-box mt-4">
<h3 class="fw-bold" style="color:#f44336;">Rejected Submissions</h3>
<div class="row g-3 mt-2">
<?php while($row = $rejected->fetch_assoc()): ?>
<div class="col-md-6">
<div class="glass-box p-3">
    <h6 class="fw-bold"><?= $row['project_title'] ?></h6>
    <p class="mb-1"><strong>Submitted By:</strong> <?= $row['submitted_by'] ?></p>
    <p class="mb-1"><strong>Roll Numbers:</strong> <?= $row['roll_numbers'] ?></p>
    <p class="mb-1"><strong>Department:</strong> <?= $row['department'] ?></p>
    <p class="mb-1"><strong>Year:</strong> <?= $row['year'] ?></p>
    <p class="mb-1"><strong>Section:</strong> <?= $row['section'] ?></p>
    <p class="mb-0"><strong>Hardcopy:</strong> <?= $row['hardcopy']?'Yes':'No' ?></p>
    <div class="mt-3">
        <a href="?action=approved&id=<?= $row['id'] ?>" class="btn btn-glass btn-success btn-action">Approve</a>
        <a href="?action=pending&id=<?= $row['id'] ?>" class="btn btn-glass btn-warning btn-action">Pending</a>
        <a href="?action=delete&id=<?= $row['id'] ?>" class="btn btn-glass btn-secondary btn-action">Delete</a>
    </div>
</div>
</div>
<?php endwhile; ?>
</div>
</div>

</div>
</body>
</html>
