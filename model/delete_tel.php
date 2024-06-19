<?php
include('../conn.php');

$id = $_POST['id'];
$tel_pic = $_POST['tel_pic'];
$current_img_path = '../img/tel/' . $tel_pic;

$sql = "DELETE FROM tel WHERE id = ?";
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
