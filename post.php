<?php
include 'db.php';
session_start();
include 'includes_header.php';

$id = $_GET['id'];
$stmt = mysqli_prepare($conn, "SELECT * FROM posts WHERE id = ?");
mysqli_stmt_bind_param($stmt, "i", $id);
mysqli_stmt_execute($stmt);
$result = mysqli_stmt_get_result($stmt);
$post = mysqli_fetch_assoc($result);
?>
<h2 class="mb-4 text-primary"><?= htmlspecialchars($post['title']) ?></h2>
<p><?= nl2br(htmlspecialchars($post['content'])) ?></p>
<a href="view_posts.php" class="btn btn-outline-secondary mt-4">Back to All Posts</a>
<?php include 'includes_footer.php'; ?>
