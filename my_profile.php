<?php
// my_profile.php

session_start();
if (!isset($_SESSION['username'])) {
    header("Location: login.php");
    exit;
}
include 'includes_header.php';

// Assuming user data is stored in session for demonstration purposes
$username = htmlspecialchars($_SESSION['username']);
$email = htmlspecialchars($_SESSION['email'] ?? 'Not provided'); // Example email from session
$bio = htmlspecialchars($_SESSION['bio'] ?? 'No bio available'); // Example bio from session

?>
<div class="container py-5">
    <div class="row justify-content-center">
        <div class="col-lg-8 col-md-10">
            <div class="card shadow-lg border-0">
                <div class="card-body">
                    <h2 class="text-center mb-4">My Profile</h2>
                    <div class="text-center mb-4">
                        <img src="assets/user_avatar.png" alt="User Avatar" class="rounded-circle mb-3" width="90" height="90">
                    </div>
                    <h4>Username: <span class="text-primary"><?= $username ?></span></h4>
                    <h4>Email: <span class="text-primary"><?= $email ?></span></h4>
                    <h4>Bio:</h4>
                    <p><?= $bio ?></p>
                    <div class="d-grid gap-2 mt-4">
                        <a href="edit_profile.php" class="btn btn-warning btn-lg">Edit Profile</a>
                        <a href="dashboard.php" class="btn btn-secondary btn-lg">Back to Dashboard</a>
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