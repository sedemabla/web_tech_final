<?php
session_start();
header('Content-Type: application/json');

require_once '../db/db.php'; // Path to your database file

$response = [];

try {
    // Total Users (excluding admins)
    $userQuery = "SELECT COUNT(*) AS total_users FROM pet_users WHERE role != 1";
    $result = $conn->query($userQuery);
    $response['total_users'] = $result->fetch_assoc()['total_users'];

    // Total DIY Projects
    $diyQuery = "SELECT COUNT(*) AS total_diy FROM pet_diy_projects";
    $result = $conn->query($diyQuery);
    $response['total_diy'] = $result->fetch_assoc()['total_diy'];

    // Total Health Tips
    $healthQuery = "SELECT COUNT(*) AS total_health FROM pet_health_tips";
    $result = $conn->query($healthQuery);
    $response['total_health'] = $result->fetch_assoc()['total_health'];

    // Total Training Tips
    $trainingQuery = "SELECT COUNT(*) AS total_training FROM pet_training_tips";
    $result = $conn->query($trainingQuery);
    $response['total_training'] = $result->fetch_assoc()['total_training'];

    // Hourly User Signups
    $hourlySignupsQuery = "
        SELECT DATE_FORMAT(created_at, '%H:00') AS hour, COUNT(*) AS total_users
        FROM pet_users
        WHERE role != 1
        AND DATE(created_at) = CURDATE() -- Today's date
        GROUP BY hour
        ORDER BY hour ASC
    ";
    $result = $conn->query($hourlySignupsQuery);
    $response['hourly_signups'] = [];
    while ($row = $result->fetch_assoc()) {
        $response['hourly_signups'][] = [
            'hour' => $row['hour'],
            'total_users' => $row['total_users']
        ];
    }

    // Recent Activities (from activities table)
    $activitiesQuery = "SELECT activity, details, created_at FROM activities ORDER BY created_at DESC LIMIT 5";
    $result = $conn->query($activitiesQuery);
    $response['recent_activities'] = [];
    while ($row = $result->fetch_assoc()) {
        $response['recent_activities'][] = $row;
    }

} catch (Exception $e) {
    $response['error'] = "Error fetching data: " . $e->getMessage();
}

echo json_encode($response);
$conn->close();
?>
