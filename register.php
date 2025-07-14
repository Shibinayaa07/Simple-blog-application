<?php
session_start();
if (isset($_SESSION['user_id'])) {
    header('Location: dashboard.php');
    exit();
}

include 'db.php';
include 'includes_header.php';

$message = '';
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $username = trim(mysqli_real_escape_string($conn, $_POST['username']));
    $password_raw = $_POST['password'];
    if (strlen($username) < 3) {
        $message = "<div class='alert alert-warning'>Username must be at least 3 characters.</div>";
    } elseif (strlen($password_raw) < 6) {
        $message = "<div class='alert alert-warning'>Password must be at least 6 characters.</div>";
    } else {
        $password = password_hash($password_raw, PASSWORD_DEFAULT);
        $checkUser = mysqli_query($conn, "SELECT * FROM users WHERE username='$username'");
        if (mysqli_num_rows($checkUser) > 0) {
            $message = "<div class='alert alert-warning'>Username already exists.</div>";
        } else {
            mysqli_query($conn, "INSERT INTO users (username, password) VALUES ('$username', '$password')");
            $message = "<div class='alert alert-success'>Registration successful. <a href='login.php'>Login now</a>.</div>";
        }
    }
}
?>
<div class="container d-flex justify-content-center align-items-center" style="min-height: 80vh;">
  <div class="card shadow p-4" style="max-width: 400px; width: 100%;">
    <h2 class="mb-4 text-center">Create Account</h2>
    <?php if (!empty($message)) echo $message; ?>
    <form method="post" autocomplete="off">
      <div class="mb-3">
        <label class="form-label">Username</label>
        <input type="text" name="username" class="form-control" required minlength="3" maxlength="32" autofocus>
      </div>
      <div class="mb-3">
        <label class="form-label">Password</label>
        <input type="password" name="password" class="form-control" required minlength="6" maxlength="64">
      </div>
      <button type="submit" class="btn btn-primary w-100">Register</button>
      <div class="mt-3 text-center">
        <small>Already have an account? <a href="login.php">Login</a></small>
      </div>
    </form>
  </div>
</div>
<?php include 'includes_footer.php'; ?>
