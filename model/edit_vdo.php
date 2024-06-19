<?php
// Include the database connection file
include('../conn.php');

// Fetch the data from the POST request
$vdo_id = $_POST['vdo_id'];
$vdo_title = $_POST['vdo_title'];
$vdo_path = $_FILES['vdo_path'];
$vdo_category = $_POST['vdo_category'];

// Fetch the current image path from the database
$sql = "SELECT vdo_path FROM vdo WHERE id = ?";
$stmt = $conn->prepare($sql);
$stmt->bind_param('s', $vdo_id);
$stmt->execute();
$stmt->bind_result($current_img_path);
$stmt->fetch();
$stmt->close();

// Check if an image file was uploaded
if ($vdo_path['size'] > 0) {
    // Generate a unique file name for the new image
    $unique_file_name = uniqid() . "_" . basename($vdo_path['name']);
    $target_dir = "../vdo/";
    $target_file = $target_dir . $unique_file_name;

    // Move the uploaded file to the target directory
    if (move_uploaded_file($vdo_path['tmp_name'], $target_file)) {
        // Delete the old image file
        if (file_exists($current_img_path)) {
            unlink($current_img_path);
        }
        // Update the database with the new image path and other details
        $sql = "UPDATE vdo SET vdo_title = ?, vdo_path = ?, vdo_category = ? WHERE id = ?";
        $stmt = $conn->prepare($sql);
        $stmt->bind_param('sssi', $vdo_title, $unique_file_name, $vdo_category, $vdo_id);
    } else {
        echo json_encode(['status' => 'error', 'message' => 'Failed to upload image']);
        exit;
    }
} else {
    // No new image file was uploaded; update other details only
    $sql = "UPDATE vdo SET vdo_title = ?, vdo_category = ? WHERE id = ?";
    $stmt = $conn->prepare($sql);
    $stmt->bind_param('ssi', $vdo_title, $vdo_category, $vdo_id);
}

// Execute the query
if ($stmt->execute()) {
    // The update was successful
    echo json_encode(['status' => 'success', 'message' => 'Success']);
} else {
    echo json_encode(['status' => 'error', 'message' => 'Failed to update record']);
}

// Close the prepared statement
$stmt->close();
// Close the database connection
$conn->close();
?>
