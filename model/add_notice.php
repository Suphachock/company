<?php
// Include the database connection file
include('../conn.php');

// Fetch the data from the POST request
$notice_title = $_POST['notice_title'] ?? '';
$notice_detail = $_POST['notice_detail'] ?? '';
$notice_date = $_POST['notice_date'];
$date = new DateTime($notice_date);
$formatted_date = $date->format('Y-m-d');
$notice_image = $_FILES['notice_image'];
$notice_names = [];

if ($notice_image['size'][0] > 0) {
    foreach ($notice_image['name'] as $key => $name) {
        $extension = pathinfo($name, PATHINFO_EXTENSION);
        $unique_file_name = substr(uniqid(), -4) . "." . $extension;
        $target_dir = "../img/notice/";
        $target_file = $target_dir . $unique_file_name;

        // ย้ายไฟล์ที่อัปโหลดไปยังไดเรกทอรีเป้าหมาย
        if (move_uploaded_file($notice_image['tmp_name'][$key], $target_file)) {
            $notice_names[] = $unique_file_name;
        } else {
            echo json_encode(['status' => 'error', 'message' => 'Failed to upload image ' . $name]);
            exit;
        }
    }
    $notice_names_str = implode(',', $notice_names);
    // SQL query for inserting a new record into the 'event' table
    $sql = "INSERT INTO notice (title, detail, img, create_date) VALUES (?, ?, ?, ?)";
    $stmt = $conn->prepare($sql);
    $stmt->bind_param('ssss', $notice_title, $notice_detail, $notice_names_str, $formatted_date);

    // Execute the query
    if ($stmt->execute()) {
        echo json_encode(['status' => 'success', 'message' => 'success']);
    } else {
        echo json_encode(['status' => 'error', 'message' => 'Failed to insert record']);
    }

    $stmt->close();
} else {
    // SQL query for inserting a new record into the 'event' table
    $sql = "INSERT INTO notice (title, detail,  create_date) VALUES (?, ?, ?)";
    $stmt = $conn->prepare($sql);
    $stmt->bind_param('sss', $notice_title, $notice_detail, $formatted_date);

    // Execute the query
    if ($stmt->execute()) {
        echo json_encode(['status' => 'success', 'message' => 'success']);
    } else {
        echo json_encode(['status' => 'error', 'message' => 'Failed to insert record']);
    }

    $stmt->close();
}
