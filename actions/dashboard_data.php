<?php
session_start();
header('Content-Type: application/json');
require_once '../db/db.php';

// Check admin access
if (!isset($_SESSION['user_id']) || $_SESSION['role'] != 1) {
    die(json_encode(['error' => 'Unauthorized access']));
}

try {
    $data = [];
    
    // Get total users (excluding admins)
    $query = "SELECT COUNT(*) as total FROM users WHERE role != 1";
    $result = $conn->query($query);
    $data['total_users'] = $result->fetch_assoc()['total'];

    // Get total DIY ideas
    $query = "SELECT COUNT(*) as total FROM diy_ideas";
    $result = $conn->query($query);
    $data['total_diy'] = $result->fetch_assoc()['total'];

    // Get total health tips
    $query = "SELECT COUNT(*) as total FROM health_tips";
    $result = $conn->query($query);
    $data['total_health'] = $result->fetch_assoc()['total'];

    // Get total training tips
    $query = "SELECT COUNT(*) as total FROM training_tips";
    $result = $conn->query($query);
    $data['total_training'] = $result->fetch_assoc()['total'];

    // Get hourly signups for today
    $query = "SELECT HOUR(created_at) as hour, COUNT(*) as count 
              FROM users 
              WHERE DATE(created_at) = CURDATE()
              GROUP BY HOUR(created_at)
              ORDER BY hour";
    $result = $conn->query($query);
    $hourly_data = [];
    while ($row = $result->fetch_assoc()) {
        $hourly_data[] = [
            'hour' => sprintf('%02d:00', $row['hour']),
            'total_users' => $row['count']
        ];
    }
    $data['hourly_signups'] = $hourly_data;

    // Get recent activities
    $query = "SELECT * FROM activity_logs 
              ORDER BY log_time DESC LIMIT 5";
    $result = $conn->query($query);
    $activities = [];
    while ($row = $result->fetch_assoc()) {
        $activities[] = [
            'activity' => $row['action'],
            'details' => $row['details'] ?? '',
            'created_at' => $row['log_time']
        ];
    }
    $data['recent_activities'] = $activities;

    echo json_encode($data);
} catch (Exception $e) {
    echo json_encode(['error' => $e->getMessage()]);
}
?>
