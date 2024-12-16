<?php
// Start session
session_start();

// Database configuration
$host = 'localhost';
$dbname = 'Lab_5b'; // Database name
$user = 'root';     // MySQL user
$password = '';     // MySQL password

// Connect to the database
$conn = new mysqli($host, $user, $password, $dbname);
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

// Delete user if action is triggered
if (isset($_GET['delete'])) {
    $matric = $_GET['delete'];
    $delete_sql = "DELETE FROM users WHERE matric = ?";
    $stmt = $conn->prepare($delete_sql);
    $stmt->bind_param("s", $matric);
    $stmt->execute();
    header("Location: display_users.php");
    exit();
}

// Fetch all users
$sql = "SELECT * FROM users";
$result = $conn->query($sql);
?>

<!DOCTYPE html>
<html>
<head>
    <title>Users Table</title>
    <style>
        table {
            width: 60%;
            margin: 20px auto;
            border-collapse: collapse;
        }
        th, td {
            border: 1px solid black;
            padding: 10px;
            text-align: center;
        }
        th {
            background-color: #f2f2f2;
        }
        a {
            color: blue;
            text-decoration: none;
        }
        a:hover {
            text-decoration: underline;
        }
    </style>
</head>
<body>
    <h2 style="text-align: center;">Users Table</h2>
    <table>
        <tr>
            <th>Matric</th>
            <th>Name</th>
            <th>Level</th>
            <th>Action</th>
        </tr>
        <?php
        // Display user data in table rows
        if ($result && $result->num_rows > 0) {
            while ($row = $result->fetch_assoc()) {
                echo "<tr>";
                echo "<td>" . htmlspecialchars($row['matric']) . "</td>";
                echo "<td>" . htmlspecialchars($row['name']) . "</td>";
                echo "<td>" . htmlspecialchars($row['role']) . "</td>";
                echo "<td>
                        <a href='update_user.php?matric=" . $row['matric'] . "'>Update</a> |
                        <a href='display_users.php?delete=" . $row['matric'] . "' onclick=\"return confirm('Are you sure you want to delete this user?');\">Delete</a>
                      </td>";
                echo "</tr>";
            }
        } else {
            echo "<tr><td colspan='4'>No data found</td></tr>";
        }
        ?>
    </table>
</body>
</html>

<?php
$conn->close();
?>
