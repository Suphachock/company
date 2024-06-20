<?php
// Include the database connection file
include('../conn.php');

$id = $_POST['id'] ?? '';
$vdo_category = $_POST['vdo_category'] ?? '';


// Prepare and execute the SQL query for updating an existing record
$sql = "UPDATE vdo_category SET vdo_category = ? WHERE id = ?";
$stmt = $conn->prepare($sql);
$stmt->bind_param('si', $vdo_category, $id);

if ($stmt->execute()) {
    echo json_encode(['status' => 'success', 'message' => 'Success']);
} else {
    echo json_encode(['status' => 'error', 'message' => 'Failed to update record']);
}

// Close the prepared statement
$stmt->close();
// Close the database connection
$conn->close();
