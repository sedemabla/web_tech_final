<?php
// Ensure session is started
if (session_status() === PHP_SESSION_NONE) {
    session_start();
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Manage Users - Admin Dashboard</title>
    <link href="https://unpkg.com/boxicons@2.1.4/css/boxicons.min.css" rel="stylesheet">
    <style>
        @import url('https://fonts.googleapis.com/css2?family=Fredoka+One&family=Poppins:wght@300;400;600&display=swap');
        
        :root {
            --dark-blue: #3E3C6E;
            --pink: #FE979B;
            --peach: #FEAE97;
            --light-pink: #F6E8DF;
            --white: #FFFFFF;
        }

        body {
            margin: 0;
            display: flex;
            font-family: 'Poppins', sans-serif;
            background-color: var(--light-pink);
        }

        /* Sidebar Styles */
        .sidebar {
            width: 250px;
            background-color: var(--dark-blue);
            color: var(--white);
            padding: 20px;
            height: 100vh;
            overflow-y: auto;
            position: fixed;
            transition: all 0.3s ease;
        }

        .sidebar h2 {
            font-family: 'Fredoka One', cursive;
            text-align: center;
            padding: 20px 0;
            margin: 0;
            border-bottom: 1px solid var(--light-pink);
        }

        .sidebar a {
            display: flex;
            align-items: center;
            gap: 10px;
            text-decoration: none;
            color: var(--white);
            margin: 10px 0;
            padding: 10px;
            border-radius: 5px;
            transition: background 0.3s ease;
        }

        .sidebar a:hover, 
        .sidebar a.active {
            background-color: var(--pink);
        }

        .sidebar .bx {
            font-size: 1.5rem;
        }

        /* Main Content styles */
        .main-content {
            margin-left: 300px; /* Match sidebar width */
            flex: 1;
            padding: 20px;
            background-color: var(--light-pink);
            min-height: 100vh;
        }

        /* Rest of your existing styles... */
    </style>
</head>
<body>
    <div class="sidebar" id="sidebar">
        <h2>Admin Panel</h2>
        <?php if (isset($_SESSION['role']) && $_SESSION['role'] == 1): ?>
            <a href="admin_dashboard.php" <?= basename($_SERVER['PHP_SELF']) == 'admin_dashboard.php' ? 'class="active"' : '' ?>>
                <i class='bx bxs-dashboard'></i>Dashboard
            </a>
            <a href="manage-users.php" <?= basename($_SERVER['PHP_SELF']) == 'manage-users.php' ? 'class="active"' : '' ?>>
                <i class='bx bxs-user-detail'></i>Manage Users
            </a>
            <a href="manage-diy.php" <?= basename($_SERVER['PHP_SELF']) == 'manage-diy.php' ? 'class="active"' : '' ?>>
                <i class='bx bx-edit-alt'></i>Manage DIY
            </a>
            <a href="manage-health-tips.php" <?= basename($_SERVER['PHP_SELF']) == 'health-tips.php' ? 'class="active"' : '' ?>>
                <i class='bx bx-health'></i>Health Tips
            </a>
            <a href="training-tips.php" <?= basename($_SERVER['PHP_SELF']) == 'training-tips.php' ? 'class="active"' : '' ?>>
                <i class='bx bx-dumbbell'></i>Training Tips
            </a>
        <?php endif; ?>

        <a href="../../actions/logout.php">
            <i class='bx bx-log-out'></i>Logout
        </a>
    </div>
    <!-- Rest of your existing content... -->
</body>
</html>