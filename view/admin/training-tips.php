<?php
session_start();
require_once '../../db/db.php';

if (!isset($_SESSION['user_id']) || $_SESSION['role'] != 1) {
    header("Location: ../../view/login.php");
    exit();
}

$query = "SELECT t.*, u.username FROM training_tips t 
          LEFT JOIN users u ON t.created_by = u.user_id 
          ORDER BY t.created_at DESC";
$result = $conn->query($query);
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Manage Training Tips - Admin Dashboard</title>
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

        .training-tip-grid {
            display: grid;
            grid-template-columns: repeat(auto-fill, minmax(300px, 1fr));
            gap: 20px;
            padding: 20px;
        }
        .training-tip-card {
            background: var(--white);
            border-radius: 8px;
            padding: 15px;
            box-shadow: 0 2px 4px rgba(0,0,0,0.1);
        }
        .training-tip-image {
            width: 100%;
            height: 200px;
            object-fit: cover;
            border-radius: 4px;
        }
        .modal {
            display: none;
            position: fixed;
            top: 0;
            left: 0;
            width: 100%;
            height: 100%;
            background: rgba(0,0,0,0.5);
            z-index: 1000;
        }
        .modal-content {
            position: absolute;
            top: 50%;
            left: 50%;
            transform: translate(-50%, -50%);
            background: var(--white);
            padding: 20px;
            border-radius: 8px;
            width: 90%;
            max-width: 500px;
        }

        .main-content {
        margin-left: 250px;
        padding: 20px;
        background-color: var(--light-pink);
        min-height: 100vh;
    }

    /* Modal Styles */
    .modal {
        display: none;
        position: fixed;
        top: 0;
        left: 0;
        width: 100%;
        height: 100%;
        background-color: rgba(0, 0, 0, 0.5);
        z-index: 1000;
        justify-content: center;
        align-items: center;
    }

    .modal-content {
        background-color: var(--white);
        padding: 25px;
        border-radius: 8px;
        width: 90%;
        max-width: 500px;
        box-shadow: 0 4px 6px rgba(0, 0, 0, 0.1);
    }

    /* Form Styles */
    .form-group {
        margin-bottom: 20px;
    }

    .form-group label {
        display: block;
        margin-bottom: 8px;
        color: var(--dark-blue);
        font-weight: 600;
    }

    .form-group input[type="text"],
    .form-group textarea,
    .form-group select {
        width: 100%;
        padding: 10px;
        border: 1px solid #ddd;
        border-radius: 4px;
        font-family: 'Poppins', sans-serif;
    }

    .form-group textarea {
        min-height: 120px;
        resize: vertical;
    }

    /* Button Styles */
    .add-btn {
        background-color: var(--peach);
        color: var(--white);
        padding: 12px 24px;
        border: none;
        border-radius: 4px;
        cursor: pointer;
        margin-bottom: 20px;
        font-family: 'Poppins', sans-serif;
        transition: background-color 0.3s ease;
    }

    .add-btn:hover {
        background-color: var(--pink);
    }

    .action-buttons button {
        padding: 8px 16px;
        border: none;
        border-radius: 4px;
        cursor: pointer;
        margin-right: 10px;
        font-family: 'Poppins', sans-serif;
    }

    .edit-btn {
        background-color: var(--peach);
        color: var(--white);
    }

    .delete-btn {
        background-color: var(--pink);
        color: var(--white);
    }

    /* Modal Display Fixes */
    .modal[style="display: block;"] {
        display: flex !important;
    }
    </style>
</head>
<body>
    <?php include 'sidebar.php'; ?>

    <div class="main-content">
        <h1>Manage Training Tips</h1>
        
        <button onclick="showAddForm()" class="add-btn">Add New Training Tip</button>

        <div class="training-tip-grid">
            <?php while ($tip = $result->fetch_assoc()): ?>
                <div class="training-tip-card">
                    <?php 
                        $image_url = !empty($tip['image_path']) ? 
                            "../../" . $tip['image_path'] : 
                            "../../assets/images/placeholder.jpg";
                    ?>
                    <img src="<?= htmlspecialchars($image_url) ?>" 
                         alt="<?= htmlspecialchars($tip['title']) ?>" 
                         class="training-tip-image"
                         onerror="this.src='../../assets/images/placeholder.jpg'">
                    <h3><?= htmlspecialchars($tip['title']) ?></h3>
                    <p><?= htmlspecialchars(substr($tip['description'], 0, 100)) ?>...</p>
                    <p><strong>Difficulty:</strong> <?= htmlspecialchars($tip['difficulty']) ?></p>
                    <div class="action-buttons">
                        <button onclick="editTip(<?= $tip['tip_id'] ?>)" class="edit-btn">Edit</button>
                        <button onclick="deleteTip(<?= $tip['tip_id'] ?>)" class="delete-btn">Delete</button>
                    </div>
                </div>
            <?php endwhile; ?>
        </div>
    </div>

    <!-- Add/Edit Modal -->
    <div id="trainingTipModal" class="modal">
        <div class="modal-content">
            <form id="trainingTipForm" action="../../actions/admin/manage_training_tips.php" method="POST" enctype="multipart/form-data">
                <input type="hidden" name="action" value="add">
                <input type="hidden" name="tip_id" id="tip_id">
                
                <div class="form-group">
                    <label>Title</label>
                    <input type="text" name="title" required>
                </div>

                <div class="form-group">
                    <label>Difficulty</label>
                    <select name="difficulty" required>
                        <option value="Beginner">Beginner</option>
                        <option value="Intermediate">Intermediate</option>
                        <option value="Advanced">Advanced</option>
                    </select>
                </div>

                <div class="form-group">
                    <label>Description</label>
                    <textarea name="description" required></textarea>
                </div>

                <div class="form-group">
                    <label>Image</label>
                    <input type="file" name="image" accept="image/*">
                </div>

                <button type="submit">Save</button>
                <button type="button" onclick="closeModal()">Cancel</button>
            </form>
        </div>
    </div>

    <script>
        function showAddForm() {
            document.getElementById('trainingTipModal').style.display = 'block';
            document.getElementById('trainingTipForm').reset();
        }

        function closeModal() {
            document.getElementById('trainingTipModal').style.display = 'none';
        }

        function editTip(id) {
            fetch(`../../actions/admin/manage_training_tips.php?action=get&tip_id=${id}`)
                .then(response => response.json())
                .then(data => {
                    document.getElementById('tip_id').value = data.tip_id;
                    document.getElementById('trainingTipForm').elements['title'].value = data.title;
                    document.getElementById('trainingTipForm').elements['difficulty'].value = data.difficulty;
                    document.getElementById('trainingTipForm').elements['description'].value = data.description;
                    document.getElementById('trainingTipForm').elements['action'].value = 'edit';
                    document.getElementById('trainingTipModal').style.display = 'block';
                });
        }

        function deleteTip(id) {
            if (confirm('Are you sure you want to delete this training tip?')) {
                window.location.href = `../../actions/admin/manage_training_tips.php?action=delete&tip_id=${id}`;
            }
        }
    </script>
</body>
</html>

