<?php
include 'db.php';
$message = '';

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $username = trim($_POST['username']);
    $password = password_hash(trim($_POST['password']), PASSWORD_DEFAULT);

    $stmt = $conn->prepare("INSERT INTO admin (username, password) VALUES (?, ?)");
    $stmt->bind_param("ss", $username, $password);

    if ($stmt->execute()) {
        $message = "Admin registered successfully!";
    } else {
        $message = "Username already exists!";
    }
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
<meta charset="UTF-8">
<meta name="viewport" content="width=device-width, initial-scale=1.0">
<title>Admin Register</title>
<link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet">
<style>
<?php include 'index_style.css'; ?> /* reuse your style from index.php */
</style>
</head>
<body class="p-4">

<div class="container">
<div class="glass-box mx-auto" style="max-width:400px;">
<h3 class="fw-bold mb-3">Admin Registration</h3>

<?php if($message): ?>
<p class="text-center" style="color:#ff9800;"><?= $message ?></p>
<?php endif; ?>

<form method="POST">
    <label class="fw-semibold">Username</label>
    <input type="text" class="form-control mb-3" name="username" required>
    
    <label class="fw-semibold">Password</label>
    <input type="password" class="form-control mb-3" name="password" required>
    
    <button type="submit" class="btn btn-glass w-100 fw-semibold">Register</button>
</form>

<p class="mt-3 text-center">
Already registered? <a href="admin_login.php" class="highlight">Login Here</a>
</p>
</div>
</div>

</body>
</html>
