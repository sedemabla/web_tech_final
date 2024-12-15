<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Manage Training Tips - Fur & Friends</title>
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
            background-color: var(--cream);
        }

        /* Sidebar */
        .sidebar {
            width: 250px;
            background-color: var(--dark-blue);
            color: var(--white);
            display: flex;
            flex-direction: column;
            position: fixed;
            height: 100%;
            overflow-y: auto;
        }

        .sidebar h2 {
            font-family: 'Fredoka One', cursive;
            text-align: center;
            padding: 20px 0;
            margin: 0;
            border-bottom: 1px solid var(--light-pink);
        }

        .sidebar a {
            color: var(--white);
            text-decoration: none;
            padding: 15px 20px;
            display: flex;
            align-items: center;
            gap: 10px;
            transition: background 0.3s ease;
        }

        .sidebar a:hover, .sidebar a.active {
            background-color: var(--pink);
        }

        .sidebar i {
            font-size: 1.5rem;
        }
        /* Main Content */
        .main {
            margin-left: 250px;
            padding: 20px;
            flex-grow: 1;
            background-color: var(--light-pink);
            overflow-y: auto;
            min-height: 100vh;
        }

        h1 {
            font-family: 'Fredoka One', cursive;
            color: var(--dark-blue);
        }

        /* Training Tips Table */
        table {
            width: 100%;
            margin-top: 20px;
            border-collapse: collapse;
            background-color: var(--white);
            box-shadow: 0 4px 6px rgba(0, 0, 0, 0.1);
            border-radius: 10px;
            overflow: hidden;
        }

        th, td {
            padding: 15px;
            text-align: center;
            border-bottom: 1px solid var(--peach);
        }

        th {
            background-color: var(--pink);
            color: var(--white);
        }

        tr:hover {
            background-color: var(--peach);
            color: var(--dark-blue);
        }

        .actions button {
            border: none;
            padding: 5px 10px;
            border-radius: 5px;
            cursor: pointer;
            margin-right: 5px;
            font-size: 0.9rem;
        }

        .actions .edit {
            background-color: var(--peach);
            color: var(--dark-blue);
        }

        .actions .delete {
            background-color: var(--pink);
            color: var(--white);
        }

        .actions button:hover {
            opacity: 0.8;
        }
    </style>
</head>
<body>

    <!-- Sidebar -->
    <div class="sidebar">
        <h2>Admin Panel</h2>
        <a href="admin_dashboard.php"><i class='bx bxs-dashboard'></i><span>Dashboard</span></a>
        <a href="manage-users.php"><i class='bx bxs-user-detail'></i><span>Manage Users</span></a>
        <a href="manage-diy.php"><i class='bx bx-edit-alt'></i><span>Manage DIY</span></a>
        <a href="health-tips.php"><i class='bx bx-health'></i><span>Health Tips</span></a>
        <a href="training-tips.php" class="active"><i class='bx bx-dumbbell'></i><span>Training Tips</span></a>
        <a href="../../admin/logout.php"><i class='bx bx-log-out'></i><span>Logout</span></a>
    </div>

    <!-- Main Content -->
    <div class="main">
        <h1>Manage Training Tips</h1>

        <!-- Training Tips Table -->
        <table>
            <thead>
                <tr>
                    <th>Tip ID</th>
                    <th>Title</th>
                    <th>Description</th>
                    <th>Actions</th>
                </tr>
            </thead>
            <tbody>
                <tr>
                    <td>1</td>
                    <td>Basic Commands</td>
                    <td>Teach commands like Sit, Stay, and Come.</td>
                    <td class="actions">
                        <button class="edit">Edit</button>
                        <button class="delete">Delete</button>
                    </td>
                </tr>
                <tr>
                    <td>2</td>
                    <td>Positive Reinforcement</td>
                    <td>Reward pets for good behavior.</td>
                    <td class="actions">
                        <button class="edit">Edit</button>
                        <button class="delete">Delete</button>
                    </td>
                </tr>
            </tbody>
        </table>
    </div>

</body>
</html>

