<?php
include('../conn.php');

$id = $_POST['id'];
$status = $_POST['status'];

// Determine the new status based on the current status
$new_status = ($status == "deactive") ? "active" : "deactive";

// Prepare the SQL statement
$sql = "UPDATE holiday SET status = ? WHERE id = ?";
$stmt = $conn->prepare($sql);

// Bind the parameters
$stmt->bind_param("si", $new_status, $id);

// Execute the statement
if ($stmt->execute()) {
    echo "success";
} else {
    echo "error";
}

// Close the statement and connection
$stmt->close();
$conn->close();
