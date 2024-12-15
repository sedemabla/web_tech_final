<div class="sidebar" id="sidebar">
    <h2>Admin Panel</h2>
    <a href="../index.php"><i class='bx bxs-home'></i><span>Home</span></a>

    <?php if (isset($_SESSION['role']) && $_SESSION['role'] == 1): ?>
        <a href="admin_dashboard.php"><i class='bx bxs-dashboard'></i><span>Dashboard</span></a>
        <a href="manage-users.php"><i class='bx bxs-user-detail'></i><span>Manage Users</span></a>
        <a href="manage-diy.php"><i class='bx bx-edit-alt'></i><span>Manage DIY</span></a>
        <a href="health-tips.php"><i class='bx bx-health'></i><span>Health Tips</span></a>
        <a href="training-tips.php"><i class='bx bx-dog'></i><span>Training Tips</span></a>
    <?php endif; ?>

    <a href="../../actions/logout.php"><i class='bx bx-log-out'></i><span>Logout</span></a>
</div>
