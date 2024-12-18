<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>User Profile - Fur & Friends</title>
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
        header h2 {
            margin: 0;
            font-family: 'Fredoka One', cursive;
        }
        header nav a {
            color: #ffffff;
            text-decoration: none;
            margin-left: 15px;
            font-weight: 600;
        }
        header nav a:hover {
            text-decoration: underline;
        }
        .container {
            max-width: 1100px;
            margin: 30px auto;
            background-color: #ffffff;
            padding: 20px;
            border-radius: 10px;
            box-shadow: 0 4px 8px rgba(0, 0, 0, 0.1);
        }
        .profile-header {
            display: flex;
            align-items: center;
            justify-content: space-between;
            margin-bottom: 20px;
        }
        .profile-header h1 {
            margin: 0;
            color: #3e3c6e;
            font-family: 'Fredoka One', cursive;
        }
        .logout-btn {
            padding: 10px 20px;
            background-color: #fe979b;
            color: #fff;
            border: none;
            border-radius: 5px;
            cursor: pointer;
            font-weight: bold;
            transition: 0.3s ease;
            text-decoration: none;
        }
        .logout-btn:hover {
            background-color: #3e3c6e;
        }
        h2 {
            color: #3e3c6e;
            margin-top: 20px;
            font-family: 'Fredoka One', cursive;
        }
        .content-grid {
            display: grid;
            grid-template-columns: repeat(auto-fit, minmax(250px, 1fr));
            gap: 20px;
            margin-top: 10px;
        }
        .content-card {
            border: 1px solid #feae97;
            background-color: #f6e8df;
            border-radius: 10px;
            padding: 15px;
            text-align: center;
            box-shadow: 0 2px 5px rgba(0, 0, 0, 0.1);
        }
        .content-card h3 {
            margin-bottom: 10px;
            color: #3e3c6e;
        }
        .content-card p {
            color: #666;
            font-size: 0.9rem;
        }
        .content-card a {
            display: inline-block;
            margin-top: 10px;
            padding: 5px 10px;
            background-color: #fe979b;
            color: #fff;
            border-radius: 5px;
            text-decoration: none;
        }
        .content-card a:hover {
            background-color: #3e3c6e;
        }
    </style>
</head>
<body>
    <!-- Header -->
    <header>
        <h2>Fur & Friends</h2>
        <nav>
            <a href="index.html">Home</a>
            <a href="diy_ideas.html">DIY Ideas</a>
            <a href="training_tips.html">Training Tips</a>
            <a href="health_tips.html">Health Tips</a>
        </nav>
    </header>

    <!-- Profile Container -->
    <div class="container">
        <div class="profile-header">
            <h1>User Profile</h1>
            <a href="logout.html" class="logout-btn">Logout</a>
        </div>

        <!-- Health Tips -->
        <h2>Your Health Tips</h2>
        <div class="content-grid">
            <div class="content-card">
                <h3>Proper Dental Care</h3>
                <p>Learn how to care for your pet's teeth and gums...</p>
                <a href="health_tips_details.html">View Details</a>
            </div>
            <div class="content-card">
                <h3>Healthy Diet</h3>
                <p>Discover the best food for your pet...</p>
                <a href="health_tips_details.html">View Details</a>
            </div>
        </div>

        <!-- DIY Ideas -->
        <h2>Your DIY Ideas</h2>
        <div class="content-grid">
            <div class="content-card">
                <h3>Homemade Pet Toy</h3>
                <p>Create a fun toy for your furry friend...</p>
                <a href="diy_details.html">View Details</a>
            </div>
            <div class="content-card">
                <h3>DIY Pet Bed</h3>
                <p>Make a cozy bed using recycled materials...</p>
                <a href="diy_details.html">View Details</a>
            </div>
        </div>

        <!-- Training Tips -->
        <h2>Your Training Tips</h2>
        <div class="content-grid">
            <div class="content-card">
                <h3>Basic Obedience</h3>
                <p>Start training your pet with simple commands...</p>
                <a href="training_tips_details.html">View Details</a>
            </div>
            <div class="content-card">
                <h3>Leash Training</h3>
                <p>Teach your pet to walk properly on a leash...</p>
                <a href="training_tips_details.html">View Details</a>
            </div>
        </div>
    </div>
</body>
</html>
