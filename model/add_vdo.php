<?php
// Include the database connection file
include('../conn.php');

$vdo_title = $_POST['vdo_title'];
$vdo_path = $_FILES['vdo_path'];
$vdo_category = $_POST['vdo_category'];

if ($vdo_path['size'] > 0) {
    // Generate a unique file name for the new video
    $unique_file_name = uniqid() . "_" . basename($vdo_path['name']);
    $target_dir = "../vdo/";
    $target_file = $target_dir . $unique_file_name;

    // Move the uploaded file to the target directory
    if (move_uploaded_file($vdo_path['tmp_name'], $target_file)) {
        // SQL query for inserting a new record into the 'vdo' table
        $sql = "INSERT INTO vdo (vdo_title, vdo_path, vdo_category) VALUES (?, ?, ?)";
        // Prepare the statement
        $stmt = $conn->prepare($sql);
        // Bind parameters (video title, video path, video category)
        $stmt->bind_param('sss', $vdo_title, $unique_file_name, $vdo_category);
    } else {
        echo json_encode(['status' => 'error', 'message' => 'Failed to upload video']);
        exit;
    }
}

// Execute the query
if ($stmt->execute()) {
    // The insertion was successful
    echo "success";
} else {
    echo json_encode(['status' => 'error', 'message' => 'Failed to insert record']);
}

// Close the prepared statement
$stmt->close();
// Close the database connection
$conn->close();
