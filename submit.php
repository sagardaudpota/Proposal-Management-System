<?php
include 'db.php';

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $project_title = $_POST['project_title'];
    $custom_title = $_POST['custom_title'];
    if($project_title == 'custom') $project_title = $custom_title;

    $submitted_by = $_POST['submitted_by'];
    $roll_numbers = $_POST['roll_numbers'];
    $department = $_POST['department'];
    $year = $_POST['year'];
    $section = $_POST['section'];
    $hardcopy = isset($_POST['hardcopy']) ? 1 : 0;

    $stmt = $conn->prepare("INSERT INTO submissions 
        (project_title, submitted_by, roll_numbers, department, year, section, hardcopy) 
        VALUES (?, ?, ?, ?, ?, ?, ?)");
    $stmt->bind_param("ssssssi", $project_title, $submitted_by, $roll_numbers, $department, $year, $section, $hardcopy);
    if($stmt->execute()){
        header("Location: index.php?success=1");
        exit;
    } else {
        echo "Error: " . $stmt->error;
    }
    $stmt->close();
}
?>
