<?php
session_start();

// Check if user is logged in and is an admin
if (!isset($_SESSION['user_id']) || $_SESSION['role'] != 1) {
    header("Location: ../../view/login.php");
    exit();
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Admin Dashboard - Fur & Friends</title>
    <link href="https://unpkg.com/boxicons@2.1.4/css/boxicons.min.css" rel="stylesheet">
    <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
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

        /* Sidebar */
        .sidebar {
            width: 250px;
            background-color: var(--dark-blue);
            color: var(--white);
            padding: 20px;
            height: 100vh;
            overflow-y: auto;
            position: fixed;
        }

        .sidebar h2 {
            font-family: 'Fredoka One', cursive;
            text-align: center;
            margin: 0;
            padding-bottom: 20px;
            border-bottom: 1px solid var(--light-pink);
        }

        .sidebar a {
            display: flex;
            align-items: center;
            gap: 10px;
            text-decoration: none;
            color: var(--white);
            padding: 10px 15px;
            border-radius: 5px;
            margin: 10px 0;
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
            background-color: var(--white);
        }

        h1 {
            color: var(--dark-blue);
            font-family: 'Fredoka One', cursive;
        }

        /* Stats Cards */
        .stats {
            display: flex;
            gap: 20px;
            margin-bottom: 20px;
        }

        .stat-card {
            flex: 1;
            background-color: var(--light-pink);
            padding: 20px;
            border-radius: 10px;
            box-shadow: 0 4px 6px rgba(0, 0, 0, 0.1);
            text-align: center;
        }

        .stat-card h3 {
            margin: 10px 0;
            font-size: 1.2rem;
            color: var(--dark-blue);
        }

        .stat-card p {
            font-size: 2rem;
            color: var(--pink);
            margin: 0;
        }

        /* Chart Section */
        .chart-container {
            background-color: var(--light-pink);
            border-radius: 10px;
            padding: 20px;
            box-shadow: 0 4px 6px rgba(0, 0, 0, 0.1);
            margin-bottom: 20px;
        }

        table {
            width: 100%;
            border-collapse: collapse;
            background-color: var(--light-pink);
            border-radius: 10px;
            box-shadow: 0 4px 6px rgba(0, 0, 0, 0.1);
        }

        th, td {
            text-align: center;
            padding: 15px;
            border-bottom: 1px solid var(--peach);
        }

        th {
            background-color: var(--pink);
            color: var(--white);
        }

        tr:hover {
            background-color: var(--peach);
        }
    </style>
</head>
<body>

    <!-- Sidebar -->
    <div class="sidebar">
        <h2>Admin Panel</h2>
        <a href="admin_dashboard.php" class="active"><i class='bx bxs-dashboard'></i><span>Dashboard</span></a>
        <a href="manage-users.php"><i class='bx bxs-user-detail'></i><span>Manage Users</span></a>
        <a href="manage-diy.php"><i class='bx bx-edit-alt'></i><span>Manage DIY</span></a>
        <a href="health-tips.php"><i class='bx bx-health'></i><span>Health Tips</span></a>
        <a href="training-tips.php"><i class='bx bx-dumbbell'></i><span>Training Tips</span></a>
        <a href="../../actions/logout.php"><i class='bx bx-log-out'></i><span>Logout</span></a>
    </div>

    <!-- Main Content -->
    <div class="main">
        <h1>Welcome, Admin</h1>

        <!-- Stats Section -->
        <div class="stats">
            <div class="stat-card">
                <h3>Total Users</h3>
                <p id="totalUsers">0</p>
            </div>
            <div class="stat-card">
                <h3>DIY Projects</h3>
                <p id="diyCount">0</p>
            </div>
            <div class="stat-card">
                <h3>Health Tips</h3>
                <p id="healthCount">0</p>
            </div>
            <div class="stat-card">
                <h3>Training Tips</h3>
                <p id="trainingCount">0</p>
            </div>
        </div>

        <!-- Chart -->
        <div class="chart-container">
            <h2>User Signups</h2>
            <canvas id="signupChart"></canvas>
        </div>

        <!-- Recent Activities -->
        <h2>Recent Activities</h2>
        <table>
            <thead>
                <tr>
                    <th>Activity</th>
                    <th>Details</th>
                    <th>Date</th>
                </tr>
            </thead>
            <tbody id="recentActivities">
                <!-- Activities will be dynamically populated -->
            </tbody>
        </table>
    </div>

    <!-- JavaScript for Data Fetching and Chart -->
    <script>
        document.addEventListener('DOMContentLoaded', fetchDashboardData);

        function fetchDashboardData() {
            fetch('../../actions/dashboard_data.php')
                .then(response => response.json())
                .then(data => {
                    document.getElementById('totalUsers').textContent = data.total_users;
                    document.getElementById('diyCount').textContent = data.diy_count;
                    document.getElementById('healthCount').textContent = data.health_count;
                    document.getElementById('trainingCount').textContent = data.training_count;

                    const tbody = document.getElementById('recentActivities');
                    tbody.innerHTML = '';
                    data.recent_activities.forEach(activity => {
                        const row = `<tr>
                            <td>${activity.activity}</td>
                            <td>${activity.details}</td>
                            <td>${activity.created_at}</td>
                        </tr>`;
                        tbody.insertAdjacentHTML('beforeend', row);
                    });

                    renderChart(data.signup_counts);
                })
                .catch(error => console.error('Error:', error));
        }

        function renderChart(signupData) {
            const ctx = document.getElementById('signupChart').getContext('2d');
            new Chart(ctx, {
                type: 'line',
                data: {
                    labels: signupData.labels,
                    datasets: [{
                        label: 'New Users',
                        data: signupData.counts,
                        borderColor: '#FE979B',
                        backgroundColor: 'rgba(254, 151, 155, 0.2)',
                        borderWidth: 2,
                        fill: true
                    }]
                },
                options: {
                    responsive: true,
                    scales: {
                        x: { beginAtZero: true },
                        y: { beginAtZero: true }
                    }
                }
            });
        }
    </script>
</body>
</html>
