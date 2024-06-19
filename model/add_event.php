<?php
// Include the database connection file
include('../conn.php');

// Fetch the data from the POST request
$event_title = $_POST['event_title'];
$event_category = $_POST['event_category'];
$event_img = $_FILES['event_img'];
$create_date = date("Y-m-d H:i:s");
$image_names = [];

// ตรวจสอบว่า event_title ถูกใช้งานแล้วหรือไม่
$sql_check_title = "SELECT COUNT(*) FROM event WHERE event_title = ? AND event_category = ?";
$stmt_check_title = $conn->prepare($sql_check_title);
$stmt_check_title->bind_param('ss', $event_title, $event_category);
$stmt_check_title->execute();
$stmt_check_title->bind_result($count);
$stmt_check_title->fetch();
$stmt_check_title->close();

if ($count > 0) {
    echo json_encode(['status' => 'error', 'message' => 'Event title already in use']);
    exit;
}

// Check if there are multiple image files uploaded
if ($event_img['size'][0] > 0) {
    // Iterate through each uploaded image file
    foreach ($event_img['name'] as $key => $name) {
        // สร้างชื่อไฟล์ที่มีความยาวสั้นลงแต่ยังคงเอกลักษณ์
        $extension = pathinfo($name, PATHINFO_EXTENSION);
        $unique_file_name = substr(uniqid(), -6) . "." . $extension;
        $target_dir = "../img/event/";
        $target_file = $target_dir . $unique_file_name;

        // ย้ายไฟล์ที่อัปโหลดไปยังไดเรกทอรีเป้าหมาย
        if (move_uploaded_file($event_img['tmp_name'][$key], $target_file)) {
            $image_names[] = $unique_file_name;
        } else {
            echo json_encode(['status' => 'error', 'message' => 'Failed to upload image ' . $name]);
            exit;
        }
    }
    // Combine all image names into a single string separated by commas
    $image_names_str = implode(',', $image_names);

    // SQL query for inserting a new record into the 'event' table
    $sql = "INSERT INTO event (event_title, event_category, event_img, create_date) VALUES (?, ?, ?, ?)";
    $stmt = $conn->prepare($sql);
    $stmt->bind_param('ssss', $event_title, $event_category, $image_names_str, $create_date);

    // Execute the query
    if ($stmt->execute()) {
        echo json_encode(['status' => 'success', 'message' => 'Success']);
    } else {
        echo json_encode(['status' => 'error', 'message' => 'Failed to insert record']);
    }

    $stmt->close();
} else {
    echo json_encode(['status' => 'error', 'message' => 'No images uploaded']);
}

// Close the database connection
$conn->close();
