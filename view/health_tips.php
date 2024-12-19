<?php
session_start();
require_once '../db/db.php';

// Add error reporting
error_reporting(E_ALL);
ini_set('display_errors', 1);

// Get filter parameters
$category = isset($_GET['category']) ? $conn->real_escape_string($_GET['category']) : '';
$search = isset($_GET['search']) ? $conn->real_escape_string($_GET['search']) : '';

// Build base query
$query = "SELECT h.*, u.username, 
          COUNT(c.comment_id) as comment_count 
          FROM health_tips h
          LEFT JOIN users u ON h.created_by = u.user_id
          LEFT JOIN comments c ON h.tip_id = c.content_id AND c.content_type = 'health_tip'";

// Add WHERE clause if needed
$where = [];
if ($category) {
    $where[] = "h.category = '$category'";
}
if ($search) {
    $where[] = "(h.title LIKE '%$search%' OR h.description LIKE '%$search%')";
}

if (!empty($where)) {
    $query .= " WHERE " . implode(' AND ', $where);
}

$query .= " GROUP BY h.tip_id ORDER BY h.created_at DESC";

try {
    $result = $conn->query($query);
    if (!$result) {
        throw new Exception($conn->error);
    }
} catch (Exception $e) {
    error_log("Query error: " . $e->getMessage());
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Health Tips - Fur & Friends</title>
    <link href="https://unpkg.com/boxicons@2.1.4/css/boxicons.min.css" rel="stylesheet">
    <style>
        @import url('https://fonts.googleapis.com/css2?family=Fredoka+One&family=Poppins:wght@300;400;600&display=swap');
        
        body {
            margin: 0;
            font-family: 'Poppins', sans-serif;
            background-color: #f6e8df;
        }
        header {
            background-color: #3e3c6e;
            color: #ffffff;
            padding: 10px 20px;
            display: flex;
            justify-content: space-between;
            align-items: center;
        }
        header nav a {
            color: #ffffff;
            margin-left: 15px;
            text-decoration: none;
            font-weight: 600;
        }
        header nav a:hover {
            text-decoration: underline;
        }
        .container {
            max-width: 1100px;
            margin: 30px auto;
            padding: 20px;
            background-color: #ffffff;
            border-radius: 10px;
            box-shadow: 0 4px 8px rgba(0, 0, 0, 0.1);
        }
        h1 {
            color: #3e3c6e;
            font-family: 'Fredoka One', cursive;
            text-align: center;
        }
        .add-button {
            display: block;
            width: fit-content;
            margin: 10px auto 20px;
            padding: 10px 20px;
            background-color: #fe979b;
            color: white;
            text-decoration: none;
            border-radius: 5px;
            text-align: center;
        }
        .add-button:hover {
            background-color: #3e3c6e;
        }
        .tips-grid {
            display: grid;
            grid-template-columns: repeat(auto-fit, minmax(250px, 1fr));
            gap: 20px;
        }
        .tip-card {
            background-color: #f6e8df;
            border: 1px solid #feae97;
            border-radius: 8px;
            padding: 15px;
            text-align: center;
        }
        .tip-card h3 {
            margin: 10px 0;
            color: #3e3c6e;
        }
        .tip-card p {
            color: #666;
            font-size: 0.9rem;
        }
        .tip-card img {
            width: 100%;
            height: 150px;
            object-fit: cover;
            border-radius: 5px;
        }
        .tip-card a {
            display: inline-block;
            margin-top: 10px;
            padding: 5px 10px;
            background-color: #fe979b;
            color: white;
            border-radius: 5px;
            text-decoration: none;
        }
        .tip-card a:hover {
            background-color: #3e3c6e;
        }
        .filters {
            margin-bottom: 2rem;
            display: flex;
            gap: 1rem;
            justify-content: center;
            flex-wrap: wrap;
        }

        .filters select,
        .filters input {
            padding: 0.5rem;
            border: 1px solid var(--peach);
            border-radius: 5px;
            font-family: 'Poppins', sans-serif;
        }

        .filters button {
            background: var(--peach);
            color: white;
            border: none;
            padding: 0.5rem 1rem;
            border-radius: 5px;
            cursor: pointer;
        }

        .filters button:hover {
            background: var(--dark-blue);
        }
    </style>
</head>
<body>
    <header>
        <h2>Fur & Friends</h2>
        <nav>
            <a href="index.php">Home</a>
            <a href="training_tips.php">Training Tips</a>
            <a href="diy_ideas.php">DIY Ideas</a>
            <a href="health_tips.php">Health Tips</a>
            <a href="about.php">About Us</a>
            <a href="contact.php">Contact</a>
        </nav>
    </header>

    <div class="container">
        <h1>Health Tips</h1>
        
        <?php if(isset($_SESSION['user_id'])): ?>
            <a href="add_health_tips.php" class="add-button">Add Health Tip</a>
        <?php endif; ?>

        <div class="filters">
            <form action="" method="GET">
                <select name="category">
                    <option value="">All Categories</option>
                    <option value="Nutrition" <?= $category == 'Nutrition' ? 'selected' : '' ?>>Nutrition</option>
                    <option value="Exercise" <?= $category == 'Exercise' ? 'selected' : '' ?>>Exercise</option>
                    <option value="Medical" <?= $category == 'Medical' ? 'selected' : '' ?>>Medical</option>
                    <option value="Grooming" <?= $category == 'Grooming' ? 'selected' : '' ?>>Grooming</option>
                </select>
                <input type="text" name="search" placeholder="Search tips..." value="<?= htmlspecialchars($search) ?>">
                <button type="submit">Filter</button>
            </form>
        </div>

        <div class="tips-grid">
            <?php if (isset($result) && $result->num_rows > 0): ?>
                <?php while ($tip = $result->fetch_assoc()): ?>
                    <div class="tip-card">
                        <img src="<?= !empty($tip['image_path']) ? 
                            "../" . htmlspecialchars($tip['image_path']) : 
                            "../assets/images/placeholder.jpg" ?>" 
                            alt="<?= htmlspecialchars($tip['title']) ?>"
                            onerror="this.src='../assets/images/placeholder.jpg'">
                        <h3><?= htmlspecialchars($tip['title']) ?></h3>
                        <p><?= htmlspecialchars(substr($tip['description'], 0, 100)) ?>...</p>
                        <p><strong>Category:</strong> <?= htmlspecialchars($tip['category']) ?></p>
                        <p><small>By <?= htmlspecialchars($tip['username']) ?></small></p>
                        <a href="health_tips_details.php?id=<?= $tip['tip_id'] ?>">Read More</a>
                    </div>
                <?php endwhile; ?>
            <?php else: ?>
                <p>No health tips found.</p>
            <?php endif; ?>
        </div>
    </div>
</body>
</html>
