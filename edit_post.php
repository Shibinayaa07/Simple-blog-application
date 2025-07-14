<?php
session_start();
include 'db.php';
if (!isset($_SESSION['username'])) {
    header("Location: login.php");
    exit;
}
include 'includes_header.php';

$id = $_GET['id'];
$stmt = mysqli_prepare($conn, "SELECT * FROM posts WHERE id = ?");
mysqli_stmt_bind_param($stmt, "i", $id);
mysqli_stmt_execute($stmt);
$result = mysqli_stmt_get_result($stmt);
$post = mysqli_fetch_assoc($result);

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $title = $_POST['title'];
    $content = $_POST['content'];
    $update = mysqli_prepare($conn, "UPDATE posts SET title = ?, content = ? WHERE id = ?");
    mysqli_stmt_bind_param($update, "ssi", $title, $content, $id);
    mysqli_stmt_execute($update);
    echo "<div class='alert alert-success'>Post updated successfully.</div>";
}
?>
<h2 class="mb-4">Edit Post</h2>
<form method="post">
  <div class="mb-3">
    <label class="form-label">Title</label>
    <input type="text" name="title" class="form-control" value="<?= htmlspecialchars($post['title']) ?>">
  </div>
  <div class="mb-3">
    <label class="form-label">Content</label>
    <textarea name="content" class="form-control" rows="8"><?= htmlspecialchars($post['content']) ?></textarea>
  </div>
  <button type="submit" class="btn btn-primary">Update Post</button>
</form>
<?php include 'includes_footer.php'; ?>