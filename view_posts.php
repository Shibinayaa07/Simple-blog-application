<?php
// Start session and include dependencies
include 'db.php';
session_start();
include 'includes_header.php';

// Handle search and pagination
$search = isset($_GET['search']) ? $_GET['search'] : '';
$page = isset($_GET['page']) && $_GET['page'] > 0 ? (int)$_GET['page'] : 1;
$limit = 5;
$start = ($page - 1) * $limit;

// Prepare and execute the search query with pagination
$searchTerm = "%$search%";
$query = "SELECT * FROM posts WHERE title LIKE ? OR content LIKE ? ORDER BY created_at DESC LIMIT $start, $limit";
$stmt = mysqli_prepare($conn, $query);
mysqli_stmt_bind_param($stmt, "ss", $searchTerm, $searchTerm);
mysqli_stmt_execute($stmt);
$result = mysqli_stmt_get_result($stmt);

// Get total number of posts for pagination
$totalStmt = mysqli_prepare($conn, "SELECT COUNT(*) AS total FROM posts WHERE title LIKE ? OR content LIKE ?");
mysqli_stmt_bind_param($totalStmt, "ss", $searchTerm, $searchTerm);
mysqli_stmt_execute($totalStmt);
$totalResult = mysqli_stmt_get_result($totalStmt);
$totalData = mysqli_fetch_assoc($totalResult);
$totalPages = ceil($totalData['total'] / $limit);
?>
<style>
body {
  background: #f8f9fa;
}
.card {
  margin-bottom: 20px;
  box-shadow: 0 2px 8px rgba(0,0,0,0.05);
}
.pagination {
  justify-content: center;
}
</style>
<h2 class="mb-4">All Posts</h2>
<form method="GET" class="mb-4">
  <input type="text" name="search" class="form-control" placeholder="Search posts..." value="<?= htmlspecialchars($search) ?>">
</form>
<?php if ($result && mysqli_num_rows($result) > 0): ?>
  <?php while ($row = mysqli_fetch_assoc($result)): ?>
    <div class="card">
      <div class="card-body">
        <h5 class="card-title"><?= htmlspecialchars($row['title']) ?></h5>
        <p class="card-text"><?= substr(strip_tags($row['content']), 0, 100) ?>...</p>
        <a href="post.php?id=<?= $row['id'] ?>" class="btn btn-sm btn-outline-info">Read More</a>
        <a href="edit_post.php?id=<?= $row['id'] ?>" class="btn btn-sm btn-warning">Edit</a>
        <a href="delete_post.php?id=<?= $row['id'] ?>" class="btn btn-sm btn-danger" onclick="return confirm('Are you sure?')">Delete</a>
      </div>
    </div>
  <?php endwhile; ?>
<?php else: ?>
  <div class="alert alert-info">No posts found.</div>
<?php endif; ?>
<?php if ($totalPages > 1): ?>
<nav>
  <ul class="pagination">
    <?php for ($i = 1; $i <= $totalPages; $i++): ?>
      <li class="page-item <?= ($i === $page) ? 'active' : '' ?>">
        <a class="page-link" href="?search=<?= urlencode($search) ?>&page=<?= $i ?>"><?= $i ?></a>
      </li>
    <?php endfor; ?>
  </ul>
</nav>
<?php endif; ?>
<?php include 'includes_footer.php'; ?>