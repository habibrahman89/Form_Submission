<?php
ini_set('display_errors', 1);
error_reporting(E_ALL);

session_start();

$error = "";
$users = [
    "admin"  => ["password" => "admin123", "role" => "admin"],
    "viewer" => ["password" => "viewer123", "role" => "viewer"]
];

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $username = $_POST['username'];
    $password = $_POST['password'];

    if (isset($users[$username]) && $users[$username]['password'] === $password) {
        $_SESSION['auth'] = true;
        $_SESSION['role'] = $users[$username]['role'];
        header("Location: dashboard.php");
        exit;
    } else {
        $error = "Invalid Credentials";
    }
}
?>
<!DOCTYPE html>
<html>
<head>
    <title>Admin Login</title>
    <link href="https://maxcdn.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css" rel="stylesheet">
    <style>
        body { background: #eaeaea; }
        .login-box {
            width: 350px;
            margin: 120px auto;
            padding: 25px;
            background: #fff;
            border-radius: 10px;
            box-shadow: 0 0 8px rgba(0,0,0,0.2);
        }
    </style>
</head>
<body>
<div class="login-box">
    <h4 class="text-center mb-3">Admin Login</h4>
    
    <?php if ($error): ?>
        <div class="alert alert-danger"><?= $error ?></div>
    <?php endif; ?>

    <form method="POST">
        <input type="text" name="username" placeholder="Username" required class="form-control mb-2">
        <input type="password" name="password" placeholder="Password" required class="form-control mb-3">
        <button class="btn btn-primary btn-block">Login</button>
    </form>
</div>
</body>
</html>