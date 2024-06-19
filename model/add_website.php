<?php
// Include the database connection file
include('../conn.php');

// Fetch the data from the POST request
$web_name = $_POST['web_name'];
$web_url = $_POST['web_url'];
$web_img = $_FILES['web_img'];

// Check if an image file was uploaded
if ($web_img['size'] > 0) {
    // Generate a unique file name for the new image
    $unique_file_name = uniqid() . "_" . basename($web_img['name']);
    $target_dir = "../img/web_pic/";
    $target_file = $target_dir . $unique_file_name;

    // Move the uploaded file to the target directory
    if (move_uploaded_file($web_img['tmp_name'], $target_file)) {
        // SQL query for inserting a new record into the 'product' table
        $sql = "INSERT INTO website (web_name,web_url,web_img) VALUES (?, ?, ?)";
        // Prepare the statement
        $stmt = $conn->prepare($sql);
        // Bind parameters (book name, book price, book quantity, book detail, image path)
        $stmt->bind_param('sss', $web_name, $web_url, $unique_file_name);
    } else {
        echo json_encode(['status' => 'error', 'message' => 'Failed to upload image']);
        exit;
    }
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