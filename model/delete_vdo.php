<?php
include('../conn.php');

$id = $_POST['id'];
$vdo_path = $_POST['vdo_path'];

$sql = "DELETE FROM vdo WHERE id = ?";
$current_img_path = '../vdo/' . $vdo_path;
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
