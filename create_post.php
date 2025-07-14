<?php
session_start();
if (!isset($_SESSION['username'])) {
    header("Location: login.php");
    exit;
}
include 'db.php';
include 'includes_header.php';

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $title = $_POST['title'];
    $content = $_POST['content'];

    $query = "INSERT INTO posts (title, content) VALUES (?, ?)";
    $stmt = mysqli_prepare($conn, $query);
    mysqli_stmt_bind_param($stmt, "ss", $title, $content);
    mysqli_stmt_execute($stmt);
    mysqli_stmt_close($stmt);

    echo "<div class='alert alert-success'>Post created successfully!</div>";
}
?>
<h2 class="mb-4">Create a New Blog Post</h2>
<form method="post">
  <div class="mb-3">
    <label class="form-label">Title</label>
    <input type="text" name="title" class="form-control" required>
  </div>
  <div class="mb-3">
    <label class="form-label">Content</label>
    <textarea name="content" rows="8" class="form-control"></textarea>
  </div>
  <button type="submit" class="btn btn-primary">Publish</button>
</form>
<?php include 'includes_footer.php'; ?>
