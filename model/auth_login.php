<?php
// Start the session
session_start();

// Include the database connection file
include('../conn.php');

// Fetch the data from the POST request
$username = $_POST['username'] ?? '';
$password = $_POST['password'] ?? '';

// Prepare the SQL query to check login credentials
$sql = "SELECT id FROM user WHERE username = ? AND password = ?";
$stmt = $conn->prepare($sql);
$stmt->bind_param('ss', $username, $password);

$stmt->execute();
$result = $stmt->get_result();

if ($result->num_rows > 0) {
    // Fetch the user details
    $user = $result->fetch_assoc();
    
    // Set session variables
    $_SESSION['id'] = $user['id'];

    echo json_encode(['status' => 'success', 'message' => 'Login Success!']);
} else {
    echo json_encode(['status' => 'error', 'message' => 'Username or Password Incorrect!']);
}

// Close the prepared statement
$stmt->close();
// Close the database connection
$conn->close();
?>
