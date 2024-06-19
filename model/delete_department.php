<?php
include('../conn.php');

// Ensure ID is provided
if (!isset($_POST['id'])) {
    echo json_encode(['status' => 'error', 'message' => 'No ID provided']);
    exit;
}

$id = $_POST['id'];

$check_sql = "SELECT COUNT(*) as count FROM user WHERE department = ?";
if ($check_stmt = $conn->prepare($check_sql)) {
    $check_stmt->bind_param("i", $id);
    $check_stmt->execute();
    $check_result = $check_stmt->get_result();
    $row = $check_result->fetch_assoc();
    $check_stmt->close(); // Close check statement early

    if ($row['count'] > 0) {
        echo json_encode(['status' => 'error', 'message' => 'Cannot delete department because it is in use.']);
    } else {
        $sql = "DELETE FROM department WHERE id = ?";
        if ($stmt = $conn->prepare($sql)) {
            $stmt->bind_param("i", $id);
            if ($stmt->execute()) {
                echo json_encode(['status' => 'success', 'message' => 'Department deleted successfully']);
            } else {
                echo json_encode(['status' => 'error', 'message' => 'Failed to delete department.']);
            }
            $stmt->close(); // Close the statement
        } else {
            echo json_encode(['status' => 'error', 'message' => 'Failed to prepare deletion query.']);
        }
    }
} else {
    echo json_encode(['status' => 'error', 'message' => 'Failed to prepare check query.']);
}

$conn->close(); // Close connection
?>
