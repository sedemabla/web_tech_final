<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>DIY Idea Details - Fur & Friends</title>
    <link href="https://unpkg.com/boxicons@2.1.4/css/boxicons.min.css" rel="stylesheet">
    <style>
        @import url('https://fonts.googleapis.com/css2?family=Fredoka+One&family=Poppins:wght@300;400;600&display=swap');
        body {
            font-family: 'Poppins', sans-serif;
            margin: 0;
            background-color: #f6e8df;
        }
        /* Banner */
        .banner {
            background-color: #3e3c6e;
            color: white;
            display: flex;
            justify-content: space-between;
            align-items: center;
            padding: 10px 20px;
        }
        .banner h1 {
            margin: 0;
            font-family: 'Fredoka One', cursive;
        }
        .banner nav a {
            color: white;
            text-decoration: none;
            margin: 0 10px;
            font-weight: 600;
        }
        .banner nav a:hover {
            color: #feae97;
        }
        .back-button {
            color: #ffffff;
            text-decoration: none;
            font-weight: 600;
        }
        .back-button i {
            margin-right: 5px;
        }
        .container {
            margin: 20px auto;
            max-width: 800px;
            background-color: white;
            padding: 20px;
            border-radius: 10px;
            box-shadow: 0 4px 8px rgba(0, 0, 0, 0.1);
        }
        h2 {
            color: #3e3c6e;
            font-family: 'Fredoka One', cursive;
            text-align: center;
        }
        .diy-image {
            width: 100%;
            max-height: 400px;
            object-fit: cover;
            border-radius: 10px;
        }
        .section-title {
            color: #3e3c6e;
            margin-top: 20px;
        }
        p, ul {
            color: #555;
        }
    </style>
</head>
<body>
    <!-- Banner -->
    <div class="banner">
        <a href="diy_ideas.html" class="back-button"><i class='bx bx-arrow-back'></i>Back</a>
        <h1>Fur & Friends</h1>
        <nav>
            <a href="home.html">Home</a>
            <a href="training_tips.html">Training Tips</a>
            <a href="diy_ideas.html">DIY Ideas</a>
            <a href="health_tips.html">Health Tips</a>
            <a href="about.html">About Us</a>
            <a href="contact.html">Contact</a>
        </nav>
    </div>

    <!-- DIY Details -->
    <div class="container">
        <h2>DIY Pet Toy</h2>
        <img src="https://via.placeholder.com/600x300" alt="DIY Toy Image" class="diy-image">
        <div>
            <h3 class="section-title">Description</h3>
            <p>Create an engaging toy for your pets using old t-shirts. This DIY is simple and requires no sewing!</p>

            <h3 class="section-title">Materials</h3>
            <ul>
                <li>Old t-shirts</li>
                <li>Scissors</li>
                <li>Rubber bands</li>
            </ul>

            <h3 class="section-title">Steps</h3>
            <ol>
                <li>Cut the t-shirts into long strips.</li>
                <li>Gather the strips together and tie a knot in the middle.</li>
                <li>Braid the strips on either side of the knot.</li>
                <li>Tie knots at both ends to secure the braids.</li>
                <li>Trim any excess fabric and let your pet enjoy the new toy!</li>
            </ol>
        </div>
    </div>
</body>
</html>