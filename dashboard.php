<?php
// dashboard.php

session_start();
if (!isset($_SESSION['username'])) {
    header("Location: login.php");
    exit;
}
include 'includes_header.php';
?>
<div class="container py-5">
    <div class="row justify-content-center">
        <div class="col-lg-8 col-md-10">
            <div class="card shadow-lg border-0">
                <div class="card-body text-center">
                    <img src="assets/user_avatar.png" alt="User Avatar" class="rounded-circle mb-3" width="90" height="90">
                    <h2 class="mb-3">Welcome, <span class="text-primary"><?= htmlspecialchars($_SESSION['username']) ?></span>!</h2>
                    <p class="lead mb-4">Manage your blog posts and profile with the options below.</p>
                    <div class="d-grid gap-3 d-md-flex justify-content-center">
                        <a href="create_post.php" class="btn btn-primary btn-lg px-4">Create New Post</a>
                        <a href="view_posts.php" class="btn btn-outline-info btn-lg px-4">View All Posts</a>
                        <a href="my_profile.php" class="btn btn-outline-secondary btn-lg px-4">My Profile</a>
                        <a href="logout.php" class="btn btn-danger btn-lg px-4">Logout</a>
                    </div>
                </div>
            </div>
            <footer class="mt-5 text-center text-muted small">
                &copy; <?= date('Y') ?> ApexPlanet Internship Dashboard. All rights reserved.
            </footer>
        </div>
    </div>
</div>
<?php include 'includes_footer.php'; ?>
