<?php
// Include the database connection file
include('../conn.php');

// Fetch the data from the POST request
$id = $_POST['id'] ?? '';  // Assuming 'userid' is passed to identify the user to edit
$fullname = $_POST['fullname'] ?? '';
$username = $_POST['username'] ?? '';
$password = $_POST['password'] ?? ''; // Password is not being hashed as per your request
$department = $_POST['department'] ?? '';
$permission = $_POST['permission'] ?? '';
$arr_permission = implode(',', $permission);

// Prepare and execute the SQL query for updating an existing record
$sql = "UPDATE user SET fullname = ?, username = ?, password = ?, department = ?, permission = ? WHERE id = ?";
$stmt = $conn->prepare($sql);
$stmt->bind_param('sssssi', $fullname, $username, $password, $department, $arr_permission, $id);

if ($stmt->execute()) {
    echo json_encode(['status' => 'success', 'message' => 'Success']);
} else {
    echo json_encode(['status' => 'error', 'message' => 'Failed to update record']);
}

// Close the prepared statement
$stmt->close();
// Close the database connection
$conn->close();
