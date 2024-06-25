<?php
// รวมไฟล์การเชื่อมต่อฐานข้อมูล
include('../conn.php');

// รับข้อมูลจากคำขอ POST
$event_id = $_POST['event_id'];
$event_title = $_POST['event_title'];
$event_category = $_POST['event_category'];
$create_date = date("Y-m-d H:i:s");
$event_img = $_FILES['event_img'];


// ดึงเส้นทางของรูปภาพปัจจุบันจากฐานข้อมูล
$sql = "SELECT event_img FROM event WHERE event_title = ? AND event_category = ?";
$stmt = $conn->prepare($sql);
$stmt->bind_param('ss', $event_title_id, $event_category);
$stmt->execute();
$stmt->bind_result($current_img_path);
$stmt->fetch();
$stmt->close();

// ตรวจสอบว่ามีการอัปโหลดไฟล์รูปภาพหรือไม่
if ($event_img['size'][0] > 0) {
    // Get the current images from the database
    $sql = "SELECT event_img FROM event WHERE id = ?";
    $stmt = $conn->prepare($sql);
    $stmt->bind_param('i', $event_id);
    $stmt->execute();
    $stmt->bind_result($current_images);
    $stmt->fetch();
    $stmt->close();

    $current_images_array = $current_images === '' ? [] : explode(',', $current_images);
    $image_names = $current_images_array;

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

    // SQL query for updating the existing record in the 'event' table
    $sql = "UPDATE event SET event_title = ?, event_category = ?, event_img = ?, create_date = ? WHERE id = ?";
    $stmt = $conn->prepare($sql);
    $stmt->bind_param('ssssi', $event_title, $event_category, $image_names_str, $create_date, $event_id);

    // Execute the query
    if (!$stmt->execute()) {
        echo json_encode(['status' => 'error', 'message' => 'Failed to update record']);
    }
    $stmt->close();
}


// อัปเดตรายละเอียดอื่น ๆ
$sql_title = "UPDATE event SET event_title = ? , event_category = ? WHERE id = ?";
$stmt_title = $conn->prepare($sql_title);
$stmt_title->bind_param('sii', $event_title, $event_category, $event_id);

// ดำเนินการคำสั่ง
if ($stmt_title->execute()) {
    // อัปเดตสำเร็จ
    echo json_encode(['status' => 'success', 'message' => 'Success']);
    // ปิด statement
    $stmt_title->close();
}

// ปิดการเชื่อมต่อฐานข้อมูล
$conn->close();
