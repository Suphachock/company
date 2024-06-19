<?php
// Include the database connection file
include('../conn.php');

// Fetch the data from the POST request
$web_id = $_POST['id'];
$web_name = $_POST['web_name'];
$web_url = $_POST['web_url'];
$web_img = $_FILES['web_img'];

// Fetch the current image path from the database
$sql = "SELECT web_img FROM website WHERE id = ?";
$stmt = $conn->prepare($sql);
$stmt->bind_param('s', $web_id);
$stmt->execute();
$stmt->bind_result($current_img_path);
$stmt->fetch();
$stmt->close();

// Check if an image file was uploaded
if ($web_img['size'] > 0) {
    // Generate a unique file name for the new image
    $unique_file_name = uniqid() . "_" . basename($web_img['name']);
    $target_dir = "../img/web_pic/";
    $target_file = $target_dir . $unique_file_name;

    // Move the uploaded file to the target directory
    if (move_uploaded_file($web_img['tmp_name'], $target_file)) {
        // Delete the old image file
        if (file_exists($current_img_path)) {
            unlink($current_img_path);
        }
        // Update the database with the new image path and other details
        $sql = "UPDATE website SET web_name = ?, web_url = ?, web_img = ? WHERE id = ?";
        $stmt = $conn->prepare($sql);
        $stmt->bind_param('sssi', $web_name, $web_url, $unique_file_name, $web_id);
    } else {
        echo json_encode(['status' => 'error', 'message' => 'Failed to upload image']);
        exit;
    }
} else {
    // No new image file was uploaded; update other details only
    $sql = "UPDATE website SET web_name = ?, web_url = ? WHERE id = ?";
    $stmt = $conn->prepare($sql);
    $stmt->bind_param('ssi', $web_name, $web_url, $web_id);
}

// Execute the query
if ($stmt->execute()) {
    // The update was successful
    echo "success";
}

// Close the prepared statement
$stmt->close();
// Close the database connection
$conn->close();
