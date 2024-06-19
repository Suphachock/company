<?php
// Include the database connection file
include('../conn.php');

// Fetch the data from the POST request
$tel_img = $_FILES['tel_img'];
$create_date = date("Y-m-d H:i:s");
// Check if an image file was uploaded
if ($tel_img['size'] > 0) {
    // Generate a unique file name for the new image
    $unique_file_name = uniqid() . "_" . basename($tel_img['name']);
    $target_dir = "../img/tel/";
    $target_file = $target_dir . $unique_file_name;

    // Move the uploaded file to the target directory
    if (move_uploaded_file($tel_img['tmp_name'], $target_file)) {
        // SQL query for inserting a new record into the 'product' table
        $sql = "INSERT INTO tel (tel_pic,create_date) VALUES (?,?)";
        // Prepare the statement
        $stmt = $conn->prepare($sql);
        // Bind parameters (book name, book price, book quantity, book detail, image path)
        $stmt->bind_param('ss',$unique_file_name,$create_date);
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