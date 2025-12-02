<?php
session_start();
include 'db.php';
$message = '';

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $username = trim($_POST['username']);
    $password = trim($_POST['password']);

    $stmt = $conn->prepare("SELECT * FROM admin WHERE username=?");
    $stmt->bind_param("s", $username);
    $stmt->execute();
    $result = $stmt->get_result()->fetch_assoc();

    if ($result && password_verify($password, $result['password'])) {
        $_SESSION['admin'] = $username;
        header("Location: admin_dashboard.php");
        exit;
    } else {
        $message = "Invalid username or password";
    }
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
<meta charset="UTF-8">
<meta name="viewport" content="width=device-width, initial-scale=1.0">
<title>Admin Login</title>
<link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet">
<style>
<?php include 'index_style.css'; ?>
</style>
</head>
<body class="p-4">

<div class="container">
<div class="glass-box mx-auto" style="max-width:400px;">
<h3 class="fw-bold mb-3">Admin Login</h3>

<?php if($message): ?>
<p class="text-center text-danger"><?= $message ?></p>
<?php endif; ?>

<form method="POST">
    <label class="fw-semibold">Username</label>
    <input type="text" class="form-control mb-3" name="username" required>
    
    <label class="fw-semibold">Password</label>
    <input type="password" class="form-control mb-3" name="password" required>
    
    <button type="submit" class="btn btn-glass w-100 fw-semibold">Login</button>
</form>

<p class="mt-3 text-center">
Not registered? <a href="admin_register.php" class="highlight">Register Here</a>
</p>
</div>
</div>

</body>
</html>
