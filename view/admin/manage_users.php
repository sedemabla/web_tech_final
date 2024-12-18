<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Manage Users - Fur & Friends</title>
    <link href='https://unpkg.com/boxicons@2.1.4/css/boxicons.min.css' rel='stylesheet'>
    <style>
        @import url('https://fonts.googleapis.com/css2?family=Fredoka+One&family=Poppins:wght@300;400;600&display=swap');
        
        body {
            margin: 0;
            font-family: 'Poppins', sans-serif;
            background-color: #F6E8DF;
        }

        header {
            background-color: #3E3C6E;
            color: white;
            text-align: center;
            padding: 20px;
            font-family: 'Fredoka One', cursive;
        }

        h1 {
            text-align: center;
            margin: 2rem 0;
            color: #3E3C6E;
        }

        table {
            width: 90%;
            margin: 2rem auto;
            border-collapse: collapse;
            background-color: #fff;
            border-radius: 10px;
            overflow: hidden;
            box-shadow: 0 4px 6px rgba(0, 0, 0, 0.1);
        }

        table th, table td {
            padding: 15px;
            border: 1px solid #ddd;
            text-align: center;
            color: #3E3C6E;
        }

        table th {
            background-color: #FEAE97;
            font-weight: bold;
        }

        table tr:hover {
            background-color: #FE979B;
            color: white;
        }

        .action-buttons button {
            background-color: #FE979B;
            color: white;
            border: none;
            padding: 8px 12px;
            cursor: pointer;
            border-radius: 5px;
            transition: 0.3s ease;
            margin: 5px;
        }

        .action-buttons button:hover {
            background-color: #3E3C6E;
        }

        .admin-buttons {
            display: flex;
            justify-content: center;
            margin: 1.5rem;
        }

        .admin-buttons a {
            text-decoration: none;
            color: white;
            background-color: #FE979B;
            padding: 10px 15px;
            margin: 0 10px;
            border-radius: 5px;
            transition: background-color 0.3s ease;
        }

        .admin-buttons a:hover {
            background-color: #3E3C6E;
        }
    </style>
</head>
<body>
    <header>Fur & Friends - Manage Users</header>

    <!-- Admin Actions -->
    <div class="admin-buttons">
        <a href="#">Add New User</a>
        <a href="#">Admin Dashboard</a>
    </div>

    <!-- Users Table -->
    <h1>Manage Users</h1>
    <table>
        <thead>
            <tr>
                <th>ID</th>
                <th>First Name</th>
                <th>Last Name</th>
                <th>Username</th>
                <th>Email</th>
                <th>Role</th>
                <th>Actions</th>
            </tr>
        </thead>
        <tbody>
            <!-- Placeholder Data for Display -->
            <tr>
                <td>1</td>
                <td>John</td>
                <td>Doe</td>
                <td>johndoe</td>
                <td>johndoe@example.com</td>
                <td>Administrator</td>
                <td class="action-buttons">
                    <button>Update Role</button>
                    <button>Delete</button>
                </td>
            </tr>
            <tr>
                <td>2</td>
                <td>Jane</td>
                <td>Smith</td>
                <td>janesmith</td>
                <td>janesmith@example.com</td>
                <td>User</td>
                <td class="action-buttons">
                    <button>Update Role</button>
                    <button>Delete</button>
                </td>
            </tr>
            <tr>
                <td>3</td>
                <td>Michael</td>
                <td>Johnson</td>
                <td>michaelj</td>
                <td>michaelj@example.com</td>
                <td>User</td>
                <td class="action-buttons">
                    <button>Update Role</button>
                    <button>Delete</button>
                </td>
            </tr>
        </tbody>
    </table>
</body>
</html>
