<?php
// Include the database connection file
include('../conn.php');

// Fetch the data from the POST request
$event_title = $_POST['event_title'];
$event_category = $_POST['event_category'];
$event_img = $_FILES['event_img'];
$create_date = date("Y-m-d H:i:s");

// Check if there are multiple image files uploaded
if ($event_img['size'][0] > 0) {
    // Check if the event title already exists
    $sql = "SELECT id FROM event WHERE event_title = ? AND event_category = ?";
    $stmt = $conn->prepare($sql);
    $stmt->bind_param('ii', $event_title, $event_category);
    $stmt->execute();
    $stmt->store_result();

    if ($stmt->num_rows > 0) {
        echo json_encode(['status' => 'error', 'message' => 'หัวข้ออีเว้นท์นี้ถูกใช้งานอยู่!']);
        exit;
    }
    $stmt->close();

    // Insert event_title and get the last inserted id
    $sql = "INSERT INTO event_title (event_title) VALUES (?)";
    $stmt = $conn->prepare($sql);
    $stmt->bind_param('s', $event_title);

    if (!$stmt->execute()) {
        echo json_encode(['status' => 'error', 'message' => 'Failed to insert event title']);
        exit;
    }

    $event_title_id = $stmt->insert_id;
    $stmt->close();

    // Get event_category id
    $sql = "SELECT id FROM event_category WHERE event_category = ?";
    $stmt = $conn->prepare($sql);
    $stmt->bind_param('s', $event_category);

    if (!$stmt->execute()) {
        echo json_encode(['status' => 'error', 'message' => 'Failed to get event category id']);
        exit;
    }

    $stmt->bind_result($event_category_id);
    $stmt->fetch();
    $stmt->close();

    // Iterate through each uploaded image file
    foreach ($event_img['name'] as $key => $name) {
        $unique_file_name = uniqid() . "_" . basename($name);
        $target_dir = "../img/event/";
        $target_file = $target_dir . $unique_file_name;

        // Move the uploaded file to the target directory
        if (move_uploaded_file($event_img['tmp_name'][$key], $target_file)) {
            // SQL query for inserting a new record into the 'event' table
            $sql = "INSERT INTO event (event_title, event_category, event_img, create_date) VALUES (?, ?, ?, ?)";
            $stmt = $conn->prepare($sql);
            $stmt->bind_param('iiss', $event_title_id, $event_category_id, $unique_file_name, $create_date);

            // Execute the query
            if (!$stmt->execute()) {
                echo json_encode(['status' => 'error', 'message' => 'Failed to insert record for ' . $name]);
                exit;
            }

            $stmt->close();
        } else {
            echo json_encode(['status' => 'error', 'message' => 'Failed to upload image ' . $name]);
            exit;
        }
    }

    // If all images are processed successfully, return a success message
    echo json_encode(['status' => 'success', 'message' => 'success']);
} else {
    echo json_encode(['status' => 'error', 'message' => 'No images uploaded']);
}

// Close the database connection
$conn->close();
?>
