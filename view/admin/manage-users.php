<?php
session_start();
require_once '../../db/db.php';

// Ensure admin access only
if (!isset($_SESSION['user_id']) || $_SESSION['role'] != 1) {
    header("Location: ../../view/login.php");
    exit();
}

// Fetch all users except current admin
$query = "SELECT user_id, username, email, role, created_at FROM users WHERE user_id != ?";
$stmt = $conn->prepare($query);
$stmt->bind_param("i", $_SESSION['user_id']);
$stmt->execute();
$result = $stmt->get_result();
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
        }

        .main-content {
            flex: 1;
            padding: 20px;
            background-color: var(--light-pink);
        }

        table {
            width: 100%;
            border-collapse: collapse;
            background: var(--white);
            border-radius: 8px;
            overflow: hidden;
            box-shadow: 0 4px 6px rgba(0, 0, 0, 0.1);
        }

        th, td {
            padding: 12px;
            text-align: left;
            border-bottom: 1px solid var(--light-pink);
        }

        th {
            background-color: var(--dark-blue);
            color: var(--white);
        }

        tr:hover {
            background-color: var(--light-pink);
        }

        .actions button {
            padding: 6px 12px;
            border: none;
            border-radius: 4px;
            cursor: pointer;
            margin: 0 4px;
        }

        .edit-btn {
            background-color: var(--peach);
            color: var(--white);
        }

        .delete-btn {
            background-color: var(--pink);
            color: var(--white);
        }

        .message {
            padding: 10px;
            margin-bottom: 20px;
            border-radius: 4px;
        }

        .success {
            background-color: #d4edda;
            color: #155724;
        }

        .error {
            background-color: #f8d7da;
            color: #721c24;
        }
    </style>
</head>
<body>
    <?php include 'sidebar.php'; ?>

    <div class="main-content">
        <h1>Manage Users</h1>

        <?php if (isset($_SESSION['success'])): ?>
            <div class="message success"><?= $_SESSION['success']; unset($_SESSION['success']); ?></div>
        <?php endif; ?>

        <?php if (isset($_SESSION['error'])): ?>
            <div class="message error"><?= $_SESSION['error']; unset($_SESSION['error']); ?></div>
        <?php endif; ?>

        <table>
            <thead>
                <tr>
                    <th>Username</th>
                    <th>Email</th>
                    <th>Role</th>
                    <th>Joined Date</th>
                    <th>Actions</th>
                </tr>
            </thead>
            <tbody>
                <?php while ($user = $result->fetch_assoc()): ?>
                <tr>
                    <td><?= htmlspecialchars($user['username']) ?></td>
                    <td><?= htmlspecialchars($user['email']) ?></td>
                    <td>
                        <form action="../../actions/admin/manage_users.php" method="POST" style="display:inline;">
                            <input type="hidden" name="action" value="update">
                            <input type="hidden" name="user_id" value="<?= $user['user_id'] ?>">
                            <select name="role" onchange="this.form.submit()">
                                <option value="2" <?= $user['role'] == 2 ? 'selected' : '' ?>>User</option>
                                <option value="1" <?= $user['role'] == 1 ? 'selected' : '' ?>>Admin</option>
                            </select>
                        </form>
                    </td>
                    <td><?= date('M d, Y', strtotime($user['created_at'])) ?></td>
                    <td class="actions">
                        <button class="delete-btn" onclick="confirmDelete(<?= $user['user_id'] ?>)">
                            <i class='bx bx-trash'></i>
                        </button>
                    </td>
                </tr>
                <?php endwhile; ?>
            </tbody>
        </table>
    </div>

    <script>
    function confirmDelete(userId) {
        if (confirm('Are you sure you want to delete this user? This action cannot be undone.')) {
            window.location.href = `../../actions/admin/manage_users.php?action=delete&user_id=${userId}`;
        }
    }
    </script>
</body>
</html>
