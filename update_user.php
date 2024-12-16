<?php
// Database configuration
$host = 'localhost';
$dbname = 'Lab_5b';
$user = 'root';
$password = '';

$conn = new mysqli($host, $user, $password, $dbname);
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

// Initialize variables
$matric = '';
$name = '';
$role = '';

// Fetch user details for updating
if (isset($_GET['matric'])) {
    $matric = $_GET['matric'];
    $sql = "SELECT * FROM users WHERE matric = ?";
    $stmt = $conn->prepare($sql);
    $stmt->bind_param("s", $matric);
    $stmt->execute();
    $result = $stmt->get_result();

    if ($result && $row = $result->fetch_assoc()) {
        $name = $row['name'];
        $role = $row['role'];
    } else {
        die("User not found.");
    }
}

// Handle form submission for update
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $matric = $_POST['matric'];
    $name = $_POST['name'];
    $role = $_POST['role'];

    $update_sql = "UPDATE users SET name = ?, role = ? WHERE matric = ?";
    $stmt = $conn->prepare($update_sql);
    $stmt->bind_param("sss", $name, $role, $matric);

    if ($stmt->execute()) {
        header("Location: display_users.php");
        exit();
    } else {
        echo "Error updating record: " . $conn->error;
    }
}
?>

<!DOCTYPE html>
<html>
<head>
    <title>Update User</title>
</head>
<body>
    <h2 style="text-align: center;">Update User</h2>
    <form method="POST" action="update_user.php">
        <table style="margin: auto;">
            <tr>
                <td>Matric:</td>
                <td><input type="text" name="matric" value="<?php echo htmlspecialchars($matric); ?>" readonly></td>
            </tr>
            <tr>
                <td>Name:</td>
                <td><input type="text" name="name" value="<?php echo htmlspecialchars($name); ?>" required></td>
            </tr>
            <tr>
                <td>Access Level:</td>
                <td><input type="text" name="role" value="<?php echo htmlspecialchars($role); ?>" required></td>
            </tr>
            <tr>
                <td colspan="2" style="text-align: center;">
                    <button type="submit">Update</button>
                    <a href="display_users.php">Cancel</a>
                </td>
            </tr>
        </table>
    </form>
</body>
</html>

<?php
$conn->close();
?>
