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
    </style>
</head>
<body>
    <header>
        <h2>Fur & Friends</h2>
        <nav>
            <a href="index.html">Home</a>
            <a href="training_tips.html">Tips & Training</a>
            <a href="diy_ideas.html">DIY Ideas</a>
            <a href="health_tips.html">Health Tips</a>
            <a href="about.html">About Us</a>
            <a href="contact.html">Contact</a>
        </nav>
    </header>

    <div class="container">
        <h1>Health Tips</h1>
        <a href="add_health_tips.html" class="add-button">Add Health Tip</a>

        <div class="tips-grid">
            <!-- Example Cards -->
            <div class="tip-card">
                <img src="assets/healthtipspic.jpg" alt="Dental Hygiene">
                <h3>Proper Dental Hygiene</h3>
                <p>Learn how to maintain your pet's dental health to avoid common issues.</p>
                <a href="health_tips_details.html">Read More</a>
            </div>
            <div class="tip-card">
                <img src="assets/healthtipspic.jpg" alt="Exercise">
                <h3>Daily Exercise</h3>
                <p>Simple exercise routines to keep your pets fit and healthy.</p>
                <a href="health_tips_details.html">Read More</a>
            </div>
        </div>
    </div>
</body>
</html>
