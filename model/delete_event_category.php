<?php
include('../conn.php');

$id = $_POST['id'];

// Check if the category is used in the 'event' table
$check_sql = "SELECT COUNT(*) as count FROM event WHERE event_category = ?";
$check_stmt = $conn->prepare($check_sql);
$check_stmt->bind_param("i", $id);
$check_stmt->execute();
$check_result = $check_stmt->get_result();
$row = $check_result->fetch_assoc();

if ($row['count'] > 0) {
    // The category is used in the 'event' table
    echo json_encode(['status' => 'error', 'message' => 'Cannot delete category because it is in use.']);
} else {
    // The category is not used, proceed with deletion
    $sql = "DELETE FROM event_category WHERE id = ?";
    $stmt = $conn->prepare($sql);
    $stmt->bind_param("i", $id);

    if ($stmt->execute()) {
        echo "success";
    } else {
        echo json_encode(['status' => 'error', 'message' => 'Failed to delete category.']);
    }

    // Close the statement
    $stmt->close();
}

// Close the check statement and connection
$check_stmt->close();
$conn->close();
?>
