<?php
// Include the database connection file
include('../conn.php');

// Fetch the data from the POST request
$vdo_id = $_POST['vdo_id'];
$vdo_title = $_POST['vdo_title'];
$vdo_category = $_POST['vdo_category'];

// Prepare SQL statement to fetch the current video paths from the database
$sql = "SELECT vdo_path FROM vdo WHERE id = ?";
$stmt = $conn->prepare($sql);
$stmt->bind_param('s', $vdo_id);
$stmt->execute();
$stmt->bind_result($current_video_paths);
$stmt->fetch();
$stmt->close();

$new_paths = [];
$target_dir = "../vdo/";

// Check if files were uploaded
if (!empty($_FILES['vdo_path']['name'][0])) {
    foreach ($_FILES['vdo_path']['name'] as $key => $filename) {
        // Process each file that successfully uploaded
        if ($_FILES['vdo_path']['error'][$key] == 0) {
            $file_tmp_name = $_FILES['vdo_path']['tmp_name'][$key];
            $unique_file_name = uniqid() . "_" . basename($filename); // Creates a unique file name
            $target_file = $target_dir . $unique_file_name; // Full path for file move

            // Move the uploaded file to the target directory
            if (move_uploaded_file($file_tmp_name, $target_file)) {
                $new_paths[] = $unique_file_name; // Store only the file name
            } else {
                echo json_encode(['status' => 'error', 'message' => "Failed to upload video $filename"]);
                exit;
            }
        }
    }
}

// Concatenate new file names to the existing ones
$updated_paths = $current_video_paths;
if (!empty($new_paths)) {
    $updated_paths .= (!empty($current_video_paths) ? ',' : '') . implode(',', $new_paths);
}

// Prepare SQL statement to update the database with new video names and other details
$sql = "UPDATE vdo SET vdo_title = ?, vdo_path = ?, vdo_category = ? WHERE id = ?";
$stmt = $conn->prepare($sql);
$stmt->bind_param('sssi', $vdo_title, $updated_paths, $vdo_category, $vdo_id);

// Execute the query and handle the result
if ($stmt->execute()) {
    echo json_encode(['status' => 'success', 'message' => 'Video updated successfully']);
} else {
    echo json_encode(['status' => 'error', 'message' => 'Failed to update record']);
}

// Close the prepared statement and the database connection
$stmt->close();
$conn->close();
