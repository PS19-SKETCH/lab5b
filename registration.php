<?php
// Database configuration
$host = 'localhost';
$dbname = 'Lab_5b'; // Change this to your database name
$user = 'root'; // Default MySQL user
$password = ''; // Default password is empty for localhost

// Connection to the database
$conn = new mysqli($host, $user, $password, $dbname);

// Check connection
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

// Handle form submission
if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    // Collect input values
    $matric = $_POST['matric'];
    $name = $_POST['name'];
    $password_input = $_POST['password'];
    $role = $_POST['role'];

    // Validate input fields
    if (!empty($matric) && !empty($name) && !empty($password_input) && !empty($role)) {
        // Prepare and bind the SQL query
        $stmt = $conn->prepare("INSERT INTO users (matric, name, password, role) VALUES (?, ?, ?, ?)");
        $stmt->bind_param("ssss", $matric, $name, $password_input, $role);

        // Execute the query
        if ($stmt->execute()) {
            echo "<p style='color:green; text-align:center;'>Record inserted successfully!</p>";
        } else {
            echo "<p style='color:red; text-align:center;'>Error: " . $stmt->error . "</p>";
        }

        $stmt->close();
    } else {
        echo "<p style='color:red; text-align:center;'>Please fill in all fields!</p>";
    }
}

$conn->close();
?>

<!DOCTYPE html>
<html>
<head>
    <title>Registration Page</title>
    <style>
        body {
            font-family: Arial, sans-serif;
            margin: 20px;
        }
        .form-container {
            width: 300px;
            margin: 0 auto;
            border: 1px solid #ccc;
            padding: 20px;
            border-radius: 5px;
            box-shadow: 0 0 10px #ccc;
        }
        input, select, button {
            width: 100%;
            margin: 5px 0;
            padding: 8px;
            box-sizing: border-box;
        }
        button {
            background-color: #4CAF50;
            color: white;
            border: none;
            cursor: pointer;
        }
        button:hover {
            background-color: #45a049;
        }
    </style>
</head>
<body>
    <h2 style="text-align:center;">User Registration</h2>
    <div class="form-container">
        <form method="POST" action="">
            <label for="matric">Matric:</label>
            <input type="text" name="matric" id="matric" required>
            
            <label for="name">Name:</label>
            <input type="text" name="name" id="name" required>
            
            <label for="password">Password:</label>
            <input type="password" name="password" id="password" required>
            
            <label for="role">Role:</label>
            <select name="role" id="role" required>
                <option value="">Please select</option>
                <option value="Admin">Admin</option>
                <option value="Student">Student</option>
                <option value="Lecturer">Lecturer</option>
            </select>
            
            <button type="submit">Submit</button>
        </form>
    </div>
</body>
</html>
