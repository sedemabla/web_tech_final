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
            font-family: 'Poppins', sans-serif;
            margin: 0;
            padding: 0;
            background-color: #f6e8df;
        }
        .container {
            margin: 30px auto;
            max-width: 900px;
            background-color: #ffffff;
            box-shadow: 0 4px 8px rgba(0, 0, 0, 0.1);
            border-radius: 10px;
            padding: 20px;
        }
        h1, h2 {
            text-align: center;
            color: #3e3c6e;
            font-family: 'Fredoka One', cursive;
        }
        form {
            display: flex;
            flex-direction: column;
            gap: 15px;
            margin: 20px 0;
        }
        label {
            font-weight: 600;
            color: #3e3c6e;
        }
        input, textarea, select, button {
            padding: 10px;
            border-radius: 5px;
            border: 1px solid #ccc;
            font-size: 1rem;
        }
        button {
            background-color: #fe979b;
            color: white;
            border: none;
            cursor: pointer;
            transition: 0.3s;
        }
        button:hover {
            background-color: #3e3c6e;
        }
        table {
            width: 100%;
            border-collapse: collapse;
            margin-top: 20px;
        }
        table th, table td {
            border: 1px solid #feae97;
            padding: 10px;
            text-align: center;
        }
        table th {
            background-color: #fe979b;
            color: white;
        }
        table tr:hover {
            background-color: #feae97;
        }
    </style>
</head>
<body>
    <div class="container">
        <h1>Add Health Tips</h1>
        <form>
            <label for="tip-title">Tip Title</label>
            <input type="text" id="tip-title" name="tip-title" placeholder="Enter title" required>

            <label for="tip-description">Description</label>
            <textarea id="tip-description" name="tip-description" rows="4" placeholder="Enter health tip details" required></textarea>

            <label for="category">Category</label>
            <select id="category" name="category">
                <option value="Nutrition">Nutrition</option>
                <option value="Exercise">Exercise</option>
                <option value="Medical Care">Medical Care</option>
                <option value="Dental Hygiene">Dental Hygiene</option>
                <option value="Mental Health">Mental Health</option>
                <option value="Preventive Care">Preventive Care</option>
                <option value="Skin and Coat Care">Skin and Coat Care</option>
                <option value="Weight Management">Weight Management</option>
            </select>

            <label for="tip-image">Upload Image</label>
            <input type="file" id="tip-image" name="tip-image" accept="image/*">

            <button type="submit">Add Tip</button>
        </form>

        <h2>Existing Health Tips</h2>
        <table>
            <thead>
                <tr>
                    <th>Title</th>
                    <th>Category</th>
                    <th>Description</th>
                </tr>
            </thead>
            <tbody>
                <tr>
                    <td>Healthy Eating</td>
                    <td>Nutrition</td>
                    <td>Feed your pets nutritious meals to ensure strong health.</td>
                </tr>
                <tr>
                    <td>Daily Brushing</td>
                    <td>Dental Hygiene</td>
                    <td>Brush your pet's teeth regularly to prevent dental disease.</td>
                </tr>
                <tr>
                    <td>Daily Walks</td>
                    <td>Exercise</td>
                    <td>Walking for 30 minutes a day improves your pet's fitness.</td>
                </tr>
                <tr>
                    <td>Stress-Free Environment</td>
                    <td>Mental Health</td>
                    <td>Create a peaceful space to reduce anxiety in pets.</td>
                </tr>
            </tbody>
        </table>
    </div>
</body>
</html>
