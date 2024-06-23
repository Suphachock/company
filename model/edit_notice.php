<?php
// รวมไฟล์การเชื่อมต่อฐานข้อมูล
include('../conn.php');

// รับค่าจากคำขอ POST
$notice_id = $_POST['id'] ?? '';
$notice_title = $_POST['notice_title'] ?? '';
$notice_detail = $_POST['notice_detail'] ?? '';
$notice_date = $_POST['notice_date'];
$date = new DateTime($notice_date);
$formatted_date = $date->format('Y-m-d');
$notice_image = $_FILES['notice_image'];

$image_names = [];

// ตรวจสอบว่ามีการอัปโหลดไฟล์รูปภาพหรือไม่
if ($notice_image['size'][0] > 0) {
    // ดึงเส้นทางของรูปภาพปัจจุบันจากฐานข้อมูล
    $sql = "SELECT img FROM notice WHERE id = ?";
    $stmt = $conn->prepare($sql);
    $stmt->bind_param('i', $notice_id);
    $stmt->execute();
    $stmt->bind_result($current_images);
    $stmt->fetch();
    $stmt->close();

    // ตรวจสอบว่ามีรูปภาพปัจจุบันหรือไม่
    if (!empty($current_images)) {
        $current_images_array = explode(',', $current_images);
        $image_names = $current_images_array;
    }

    // วนลูปแต่ละไฟล์รูปภาพที่อัปโหลด
    foreach ($notice_image['name'] as $key => $name) {
        // สร้างชื่อไฟล์ที่มีความยาวสั้นลงแต่ยังคงเอกลักษณ์
        $extension = pathinfo($name, PATHINFO_EXTENSION);
        $unique_file_name = substr(uniqid(), -4) . "." . $extension;
        $target_dir = "../img/notice/";
        $target_file = $target_dir . $unique_file_name;

        // ย้ายไฟล์ที่อัปโหลดไปยังไดเรกทอรีเป้าหมาย
        if (move_uploaded_file($notice_image['tmp_name'][$key], $target_file)) {
            $image_names[] = $unique_file_name;
        } else {
            echo json_encode(['status' => 'error', 'message' => 'Failed to upload image ' . $name]);
            exit;
        }
    }
    // รวมชื่อไฟล์รูปภาพทั้งหมดเป็นสตริงเดียวโดยคั่นด้วยคอมมา
    $image_names_str = implode(',', $image_names);

    $sql = "UPDATE notice SET title = ?, detail = ?, img = ?, create_date = ? WHERE id = ?";
    $stmt = $conn->prepare($sql);
    $stmt->bind_param('ssssi', $notice_title, $notice_detail, $image_names_str, $formatted_date, $notice_id);

    // ดำเนินการคำสั่ง
    if (!$stmt->execute()) {
        echo json_encode(['status' => 'error', 'message' => 'Failed to update record']);
        $stmt->close();
        $conn->close();
        exit;
    }
    $stmt->close();
}

// หากไม่มีการอัปโหลดรูปภาพใหม่ ให้ทำการอัปเดตเฉพาะ title, detail และ create_date
if (!isset($image_names_str)) {
    $sql = "UPDATE notice SET title = ?, detail = ?, create_date = ? WHERE id = ?";
    $stmt = $conn->prepare($sql);
    $stmt->bind_param('sssi', $notice_title, $notice_detail, $formatted_date, $notice_id);
    if (!$stmt->execute()) {
        echo json_encode(['status' => 'error', 'message' => 'Failed to update record']);
        $stmt->close();
        $conn->close();
        exit;
    }
    $stmt->close();
}

// ส่งการตอบสนองสำเร็จ
echo json_encode(['status' => 'success', 'message' => 'Success']);

// ปิดการเชื่อมต่อฐานข้อมูล
$conn->close();
?>
