<?php
// Start session to manage login status
session_start();

// Database configuration
$host = 'localhost';
$dbname = 'Lab_5b'; // Your database name
$user = 'root';     // Default user
$password = '';     // Default password is blank

// Connect to the database
$conn = new mysqli($host, $user, $password, $dbname);

// Check database connection
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

// Initialize variables
$error_message = '';

// Handle form submission
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    // Get input values
    $matric = $_POST['matric'];
    $password_input = $_POST['password'];

    // Validate input fields
    if (!empty($matric) && !empty($password_input)) {
        // Prepare and execute query
        $stmt = $conn->prepare("SELECT * FROM users WHERE matric = ? AND password = ?");
        $stmt->bind_param("ss", $matric, $password_input);
        $stmt->execute();
        $result = $stmt->get_result();

        // Check if user exists
        if ($result->num_rows > 0) {
            // Set session and redirect to the display page
            $_SESSION['matric'] = $matric;
            header("Location: display_users.php"); // Redirect to Question 5 page
            exit();
        } else {
            // Invalid credentials
            $error_message = "Invalid username or password, try <a href='login.php'>login</a> again.";
        }

        $stmt->close();
    } else {
        $error_message = "Please enter both Matric and Password.";
    }
}

$conn->close();
?>

<!DOCTYPE html>
<html>
<head>
    <title>Login Page</title>
    <style>
        body {
            font-family: Arial, sans-serif;
            margin: 20px;
            text-align: center;
        }
        .form-container {
            width: 300px;
            margin: 0 auto;
            border: 1px solid #ccc;
            padding: 20px;
            border-radius: 5px;
            box-shadow: 0 0 10px #ccc;
        }
        input, button {
            width: 100%;
            margin: 5px 0;
            padding: 8px;
            box-sizing: border-box;
        }
        a {
            color: purple;
            text-decoration: none;
        }
        a:hover {
            text-decoration: underline;
        }
        .error {
            color: red;
        }
    </style>
</head>
<body>
    <h2>Login Page</h2>
    <div class="form-container">
        <form method="POST" action="login.php">
            <label for="matric">Matric:</label>
            <input type="text" id="matric" name="matric" required>

            <label for="password">Password:</label>
            <input type="password" id="password" name="password" required>

            <button type="submit">Login</button>
        </form>
        <p>
            <a href="registration.php">Register</a> here if you have not.
        </p>
        <?php if ($error_message): ?>
            <p class="error"><?php echo $error_message; ?></p>
        <?php endif; ?>
    </div>
</body>
</html>
