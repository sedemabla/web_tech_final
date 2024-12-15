<?php
session_start();
require_once '../../db/db.php';

// Ensure admin access only
if (!isset($_SESSION['user_id']) || $_SESSION['role'] != 1) {
    header("Location: ../login.php");
    exit();
}

// Fetch all users
$query = "SELECT user_id, first_name, last_name, email, role FROM pet_users";
$result = $conn->query($query);

?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Manage Users - Fur & Friends</title>
    <link href="https://unpkg.com/boxicons@2.1.4/css/boxicons.min.css" rel="stylesheet">
    <style>
        /* Sidebar and Page Styling */
        @import url('https://fonts.googleapis.com/css2?family=Fredoka+One&family=Poppins:wght@300;400;600&display=swap');
        :root { --dark-blue: #3E3C6E; --pink: #FE979B; --peach: #FEAE97; --light-pink: #F6E8DF; --white: #FFFFFF; }
        body { margin: 0; font-family: 'Poppins', sans-serif; display: flex; min-height: 100vh; background-color: var(--light-pink); }
        .sidebar { width: 250px; background-color: var(--dark-blue); color: var(--white); position: fixed; height: 100%; overflow-y: auto; }
        .sidebar h2 { font-family: 'Fredoka One', cursive; text-align: center; padding: 20px; border-bottom: 1px solid var(--light-pink); }
        .sidebar a { color: var(--white); text-decoration: none; padding: 15px; display: flex; align-items: center; gap: 10px; }
        .sidebar a:hover, .sidebar a.active { background-color: var(--pink); }
        .sidebar i { font-size: 1.5rem; }

        /* Main Content */
        .main-content { margin-left: 250px; padding: 20px; flex-grow: 1; background-color: var(--white); }
        h1 { font-family: 'Fredoka One', cursive; color: var(--dark-blue); margin-bottom: 20px; }
        table { width: 100%; border-collapse: collapse; box-shadow: 0 4px 6px rgba(0, 0, 0, 0.1); }
        th, td { padding: 15px; text-align: center; border-bottom: 1px solid var(--peach); }
        th { background-color: var(--pink); color: var(--white); }
        tr:hover { background-color: var(--peach); }
        .action-buttons button { border: none; padding: 5px 10px; border-radius: 5px; cursor: pointer; }
        .edit-btn { background-color: var(--peach); color: var(--dark-blue); }
        .delete-btn { background-color: var(--pink); color: var(--white); }
        .edit-btn:hover, .delete-btn:hover { opacity: 0.9; }

        /* Modal */
        .modal { display: none; position: fixed; top: 0; left: 0; width: 100%; height: 100%; background: rgba(0, 0, 0, 0.5); justify-content: center; align-items: center; }
        .modal-content { background-color: var(--white); padding: 20px; border-radius: 10px; width: 400px; }
        .modal-content input, .modal-content select { width: 100%; padding: 8px; margin-bottom: 15px; }
    </style>
</head>
<body>
    <!-- Sidebar -->
    <div class="sidebar">
        <h2>Admin Panel</h2>
        <a href="admin_dashboard.php"><i class='bx bxs-dashboard'></i>Dashboard</a>
        <a href="manage-users.php" class="active"><i class='bx bxs-user-detail'></i>Manage Users</a>
        <a href="manage-diy.php"><i class='bx bx-edit-alt'></i>Manage DIY</a>
        <a href="health-tips.php"><i class='bx bx-health'></i>Health Tips</a>
        <a href="training-tips.php"><i class='bx bx-dumbbell'></i>Training Tips</a>
        <a href="../../assets/logout.php"><i class='bx bx-log-out'></i>Logout</a>
    </div>

    <!-- Main Content -->
    <div class="main-content">
        <h1>Manage Users</h1>
        <table>
            <thead>
                <tr>
                    <th>User ID</th>
                    <th>Name</th>
                    <th>Email</th>
                    <th>Role</th>
                    <th>Actions</th>
                </tr>
            </thead>
            <tbody>
                <?php while ($row = $result->fetch_assoc()): ?>
                <tr>
                    <td><?= htmlspecialchars($row['user_id']); ?></td>
                    <td><?= htmlspecialchars($row['first_name'] . ' ' . $row['last_name']); ?></td>
                    <td><?= htmlspecialchars($row['email']); ?></td>
                    <td><?= $row['role'] == 1 ? 'Admin' : 'User'; ?></td>
                    <td>
                        <button class="edit-btn" onclick="openModal(<?= $row['user_id']; ?>, '<?= htmlspecialchars($row['first_name']); ?>', '<?= htmlspecialchars($row['email']); ?>', <?= $row['role']; ?>)">Edit</button>
                        <button class="delete-btn" onclick="confirmDelete(<?= $row['user_id']; ?>)">Delete</button>
                    </td>
                </tr>
                <?php endwhile; ?>
            </tbody>
        </table>
    </div>

    <!-- Edit User Modal -->
    <div class="modal" id="editModal">
        <div class="modal-content">
            <h2>Edit User</h2>
            <form method="POST" action="update_user.php">
                <input type="hidden" id="edit-user-id" name="user_id">
                <label for="edit-name">Name:</label>
                <input type="text" id="edit-name" name="name" required>
                <label for="edit-email">Email:</label>
                <input type="email" id="edit-email" name="email" required>
                <label for="edit-role">Role:</label>
                <select id="edit-role" name="role">
                    <option value="1">Admin</option>
                    <option value="2">User</option>
                </select>
                <button type="submit">Save</button>
                <button type="button" onclick="closeModal()">Cancel</button>
            </form>
        </div>
    </div>

    <script>
        function openModal(id, name, email, role) {
            document.getElementById('editModal').style.display = 'flex';
            document.getElementById('edit-user-id').value = id;
            document.getElementById('edit-name').value = name;
            document.getElementById('edit-email').value = email;
            document.getElementById('edit-role').value = role;
        }

        function closeModal() {
            document.getElementById('editModal').style.display = 'none';
        }

        function confirmDelete(userId) {
            if (confirm('Are you sure you want to delete this user?')) {
                window.location.href = `delete_user.php?user_id=${userId}`;
            }
        }
    </script>
</body>
</html>
