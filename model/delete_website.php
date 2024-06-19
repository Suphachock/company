<?php
include('../conn.php');

$id = $_POST['id'];
$web_img = $_POST['web_img'];
$current_img_path = '../img/web_pic/' . $web_img;
$sql = "DELETE FROM website WHERE id = ?";
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