<?php
include('../conn.php');

$id = $_POST['id'];
$holiday_img = $_POST['holiday_img'];
$current_img_path = '../img/holiday/' . $holiday_img;

$sql = "DELETE FROM holiday WHERE id = ?";
$stmt = $conn->prepare($sql);

// Bind the parameter
$stmt->bind_param("i", $id);

// Execute the statement
if ($stmt->execute()) {
    unlink($current_img_path);
    echo "success";
}

// Close the statement and connection
$stmt->close();
$conn->close();
