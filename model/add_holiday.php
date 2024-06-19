<?php
// Include the database connection file
include('../conn.php');

// Fetch the data from the POST request
$holiday_imgs = $_FILES['holiday_img'];
$create_date = date("Y-m-d H:i:s");

// Check if there are multiple image files uploaded
if ($holiday_imgs['size'][0] > 0) {
    // Iterate through each uploaded image file
    foreach ($holiday_imgs['name'] as $key => $name) {
        $unique_file_name = uniqid() . "_" . basename($name);
        $target_dir = "../img/holiday/";
        $target_file = $target_dir . $unique_file_name;

        // Move the uploaded file to the target directory
        if (move_uploaded_file($holiday_imgs['tmp_name'][$key], $target_file)) {
            // SQL query for inserting a new record into the 'holiday' table
            $sql = "INSERT INTO holiday (holiday_img, create_date, `status`) VALUES (?, ?, 'active')";
            // Prepare the statement
            $stmt = $conn->prepare($sql);
            // Bind parameters (image path, create date)
            $stmt->bind_param('ss', $unique_file_name, $create_date);

            // Execute the query
            if (!$stmt->execute()) {
                // If any insertion fails, return an error message
                echo json_encode(['status' => 'error', 'message' => 'Failed to insert record for ' . $name]);
                exit;
            }

            // Close the prepared statement
            $stmt->close();
        } else {
            echo json_encode(['status' => 'error', 'message' => 'Failed to upload image ' . $name]);
            exit;
        }
    }

    // If all images are processed successfully, return a success message
    echo "success";
} else {
    echo json_encode(['status' => 'error', 'message' => 'No images uploaded']);
}

// Close the database connection
$conn->close();
?>
