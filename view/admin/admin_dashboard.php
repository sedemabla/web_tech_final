<?php
session_start();

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
            transition: all 0.3s ease;
        }
        .sidebar h2 {
            font-family: 'Fredoka One', cursive;
            text-align: center;
            padding: 20px 0;
            margin: 0;
            border-bottom: 1px solid var(--light-pink);
        }

        .sidebar.shrink {
            width: 60px;
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

        .sidebar a:hover, .sidebar a.active {
            background-color: var(--pink);
        }

        .sidebar .bx {
            font-size: 1.5rem;
        }

        /* Main Content */
        .main {
            flex-grow: 1;
            padding: 20px;
            background-color: var(--white);
            overflow-y: auto;
        }

        .stats {
            display: flex;
            gap: 20px;
        }

        .stat-card {
            flex: 1;
            background-color: var(--light-pink);
            border-radius: 10px;
            text-align: center;
            padding: 20px;
            box-shadow: 0 4px 6px rgba(0, 0, 0, 0.1);
        }

        .stat-card h3 {
            margin: 10px 0;
            font-size: 1.2rem;
            color: var(--dark-blue);
        }

        .stat-card p {
            font-size: 2rem;
            color: var(--pink);
        }

        .chart-container {
            margin-top: 20px;
            background-color: var(--light-pink);
            padding: 20px;
            border-radius: 10px;
        }

        table {
            width: 100%;
            margin-top: 20px;
            border-collapse: collapse;
        }

        th, td {
            padding: 10px;
            border: 1px solid var(--peach);
            text-align: center;
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
        <a href="admin_dashboard.php" class="active"><i class='bx bxs-dashboard'></i>Dashboard</a>
        <a href="manage-users.php"><i class='bx bxs-user-detail'></i>Manage Users</a>
        <a href="manage-diy.php"><i class='bx bx-edit-alt'></i>Manage DIY</a>
        <a href="health-tips.php"><i class='bx bx-health'></i>Health Tips</a>
        <a href="training-tips.php"><i class='bx bx-dumbbell'></i>Training Tips</a>
        <a href="../../actions/logout.php"><i class='bx bx-log-out'></i>Logout</a>
    </div>

    <!-- Main Content -->
    <div class="main">
        <h1>Welcome, Admin</h1>

        <!-- Quick Stats -->
        <div class="stats">
            <div class="stat-card">
                <h3>Total Users</h3>
                <p id="total-users">0</p>
            </div>
            <div class="stat-card">
                <h3>DIY Projects</h3>
                <p id="total-diy">0</p>
            </div>
            <div class="stat-card">
                <h3>Health Tips</h3>
                <p id="total-health">0</p>
            </div>
            <div class="stat-card">
                <h3>Training Tips</h3>
                <p id="total-training">0</p>
            </div>
        </div>

        <!-- Recent User Signups -->
        <div class="chart-container">
            <h2>Recent User Signups</h2>
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
            <tbody id="recent-activities">
                <!-- Activities will be dynamically populated -->
            </tbody>
        </table>
    </div>

    <script>
    fetch('../../actions/dashboard_data.php')
        .then(response => response.json())
        .then(data => {
            // Update stats
            document.getElementById('total-users').innerText = data.total_users || 0;
            document.getElementById('total-diy').innerText = data.total_diy || 0;
            document.getElementById('total-health').innerText = data.total_health || 0;
            document.getElementById('total-training').innerText = data.total_training || 0;

            // Populate recent activities
            const activityTable = document.getElementById('recent-activities');
            data.recent_activities.forEach(activity => {
                const row = `
                    <tr>
                        <td>${activity.activity}</td>
                        <td>${activity.details}</td>
                        <td>${activity.created_at}</td>
                    </tr>`;
                activityTable.innerHTML += row;
            });

            // Hourly User Signups Chart
            const hours = data.hourly_signups.map(item => item.hour);
            const userCounts = data.hourly_signups.map(item => item.total_users);

            const ctx = document.getElementById('signupChart').getContext('2d');
            new Chart(ctx, {
                type: 'line',
                data: {
                    labels: hours,
                    datasets: [{
                        label: 'Hourly User Signups (Today)',
                        data: userCounts,
                        borderColor: '#FE979B',
                        backgroundColor: 'rgba(254, 151, 155, 0.2)',
                        borderWidth: 2,
                        pointRadius: 5,
                        pointBackgroundColor: '#FE979B',
                        fill: true
                    }]
                },
                options: {
                    responsive: true,
                    scales: {
                        x: {
                            title: {
                                display: true,
                                text: 'Hour (24-hour format)'
                            }
                        },
                        y: {
                            beginAtZero: true,
                            title: {
                                display: true,
                                text: 'Number of Signups'
                            }
                        }
                    }
                }
            });
        })
        .catch(error => console.error('Error fetching dashboard data:', error));
</script>



</body>
</html>
