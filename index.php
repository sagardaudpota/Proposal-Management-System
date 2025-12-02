<?php
include 'db.php';

// Fetch submissions by status
$approved = $conn->query("SELECT * FROM submissions WHERE status='approved' ORDER BY submission_date DESC");
$rejected = $conn->query("SELECT * FROM submissions WHERE status='rejected' ORDER BY submission_date DESC");
$pending  = $conn->query("SELECT * FROM submissions WHERE status='pending' ORDER BY submission_date DESC");
?>

<!DOCTYPE html>
<html lang="en">
<head>
<meta charset="UTF-8">
<meta name="viewport" content="width=device-width, initial-scale=1.0">
<title>Applied Physics Projects</title>
<link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet">
<style>
* {
    margin:0; padding:0; box-sizing:border-box; font-family: 'Poppins', sans-serif;
}
body {
    background: linear-gradient(135deg,#0d0d0d,#1b1b1b,#222);
    color:#e6e6e6;
    overflow-x:hidden;
}
/* Loader */
#loader {
    position: fixed;
    width:100%; height:100vh;
    background:#0d0d0d;
    display:flex; justify-content:center; align-items:center;
    z-index:9999;
}
.spin {
    width:65px; height:65px;
    border:6px solid rgba(255,255,255,0.3);
    border-top-color:#9d4edd;
    border-radius:50%;
    animation: spin 1s linear infinite;
}
@keyframes spin { to { transform: rotate(360deg); } }

/* Glassmorphism */
.glass-box {
    background: rgba(255,255,255,0.08);
    border-radius:18px;
    padding:25px;
    border:1px solid rgba(255,255,255,0.18);
    backdrop-filter: blur(15px);
    box-shadow:0 5px 18px rgba(0,0,0,0.45);
    animation: fade 0.9s ease-in-out;
}
.glass-box:hover { transform: translateY(-5px); box-shadow:0 10px 25px rgba(0,0,0,0.55);}
@keyframes fade { from{opacity:0; transform:translateY(15px);} to{opacity:1; transform:translateY(0);} }

.btn-glass {
    background: rgba(255,255,255,0.08);
    color:#fff;
    border:1px solid rgba(255,255,255,0.18);
}
.btn-glass:hover { background: rgba(255,255,255,0.12); }

.highlight { color:#bb86fc; font-weight:600; }

.credit {
    margin-top:40px;
    padding:10px 0;
    text-align:center;
    color:#b1b1b1;
    font-size:14px;
}
.credit a { color:#bb86fc; text-decoration:none; font-weight:600; }
</style>
</head>
<body>

<!-- Loader -->
<div id="loader"><div class="spin"></div></div>

<div class="container py-5" id="mainContent" style="display:none;">
<h1 class="text-center mb-4 fw-bold" style="color:#bb86fc;">Applied Physics Project</h1>

<!-- Project Form -->
<div class="glass-box mt-4">
<h3 class="fw-bold mb-3">Proposal Submission Form</h3>
<form action="submit.php" method="POST">
    <label class="fw-semibold">Project Title</label>
   <select class="form-select mt-1 mb-3" name="project_title" id="projectTitle" onchange="toggleCustomTitle()" required>
    <option value="" disabled selected>Select a Project</option>
    <option>Smart Dustbin</option>
    <option>Solar Mobile Charger</option>
    <option>Smart Door Lock</option>
    <option>Mini Power Bank</option>
    <option>Digital Thermometer</option>
    <option>Automatic Street Light</option>
    <option>Rain Detector</option>
    <option>Temperature Controlled Fan</option>
    <option>Burglar Alarm</option>
    <option>Light Follower Robot</option>
    <option>Water Level Indicator</option>
    <option>Fire Alarm System</option>
    <option>Simple IR Obstacle Detector</option>
    <option>Clap Switch</option>
    <option>Touch Sensor Light</option>
    <option value="custom">Other (Add Your Own)</option>
</select>

    <input type="text" name="custom_title" id="customTitleInput" class="form-control mb-3" style="display:none;" placeholder="Enter your project title">

    <label class="fw-semibold">Submitted By</label>
    <textarea class="form-control mt-1 mb-3" name="submitted_by" rows="2" placeholder="Enter all member names separated by commas" required></textarea>

    <label class="fw-semibold">Roll Numbers</label>
    <textarea class="form-control mt-1 mb-3" name="roll_numbers" rows="2" placeholder="Enter all roll numbers separated by commas" required></textarea>

    <label class="fw-semibold">Department</label>
    <select class="form-select mt-1 mb-3" name="department" required>
        <option disabled selected>Select Department</option>
        <option>Computer Science</option>
        <option>Software Engineering</option>
    </select>

    <label class="fw-semibold">Year</label>
    <select class="form-select mt-1 mb-3" name="year" required>
        <option disabled selected>Select Year</option>
        <option>2024</option>
        <option>2025</option>
    </select>

    <label class="fw-semibold">Section</label>
    <select class="form-select mt-1 mb-3" name="section" required>
        <option disabled selected>Select Section</option>
        <option>Alpha</option>
        <option>Bravo</option>
    </select>

    <div class="form-check mb-3">
        <input type="checkbox" name="hardcopy" class="form-check-input" id="hardcopyCheck">
        <label class="form-check-label fw-semibold" for="hardcopyCheck">Proposal submitted in hardcopy?</label>
    </div>

    <button type="submit" class="btn btn-glass w-100 fw-semibold">Submit</button>
</form>
</div>

<!-- Pending Submissions -->
<div class="glass-box mt-4">
<h3 class="fw-bold" style="color:#ffc107;">Pending Proposals</h3>
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
            <p class="mb-0"><strong>Hardcopy Submitted:</strong> <?= $row['hardcopy'] ? 'Yes':'No' ?></p>
        </div>
    </div>
<?php endwhile; ?>
</div>
</div>

<!-- Approved & Rejected Sections -->
<div class="glass-box mt-4">
<h3 class="fw-bold" style="color:#4caf50;">Approved Proposals</h3>
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
            <p class="mb-0"><strong>Hardcopy Submitted:</strong> <?= $row['hardcopy'] ? 'Yes':'No' ?></p>
        </div>
    </div>
<?php endwhile; ?>
</div>

<h3 class="mt-5 fw-bold" style="color:#f44336;">Rejected Proposals</h3>
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
            <p class="mb-0"><strong>Hardcopy Submitted:</strong> <?= $row['hardcopy'] ? 'Yes':'No' ?></p>
        </div>
    </div>
<?php endwhile; ?>
</div>
</div>

<!-- Credit Section -->
<div class="glass-box mt-4">
<h3 class="fw-bold">Website Development Credit:</h3>
<p class="mt-2">
    Name: <span class="highlight">Sagar Habib</span><br>
    Roll Number: <span class="highlight">25BSSE008</span><br>
    Class: <span class="highlight">Software Bravo 25</span><br>
    Portfolio: <span class="highlight"><a href="https://sagarhabib.softisense.site" target="_blank">Click Here</a></span>
</p>
</div>

</div>

<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.bundle.min.js"></script>
<script>
window.onload = function() {
    setTimeout(() => {
        document.getElementById("loader").style.display="none";
        document.getElementById("mainContent").style.display="block";
    }, 1200);
};
function toggleCustomTitle(){
    const project = document.getElementById('projectTitle').value;
    const customInput = document.getElementById('customTitleInput');
    customInput.style.display = (project=='custom') ? 'block':'none';
}
</script>

</body>
</html>
