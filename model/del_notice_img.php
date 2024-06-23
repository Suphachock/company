<?php
include('../conn.php'); // รวมไฟล์เชื่อมต่อฐานข้อมูล

$img_arr = $_POST['hiddenImagesNotice']; // รับอาเรย์ของ URL รูปภาพจาก POST
$current_img_path = '../img/notice/'; // พาธของรูปภาพ
$id = $_POST['id']; // รับ id ของ event จาก POST
$filenames = array_map(function ($url) {
    return basename($url); // ดึงชื่อไฟล์จาก URL
}, $img_arr);

// ดึงข้อมูลรูปภาพของ event ตาม id ที่ได้รับมา
$sql_select = "SELECT img FROM notice WHERE id = ?";
$stmt_select = $conn->prepare($sql_select);
$stmt_select->bind_param("i", $id);
$stmt_select->execute();
$result = $stmt_select->get_result();

if (!$result) {
    die(json_encode(['status' => 'error', 'message' => 'Failed to retrieve event images.']));
}

// อาเรย์สำหรับเก็บชื่อรูปภาพที่เหลืออยู่
$new_img_paths = [];

if ($row = $result->fetch_assoc()) {
    $img_paths = explode(',', $row['img']); // แยกชื่อไฟล์รูปภาพออกตามจุลภาค
    foreach ($img_paths as $img) {
        if (in_array($img, $filenames)) { // ถ้ารูปภาพอยู่ในอาเรย์ $filenames
            $img_path = $current_img_path . $img;
            if (file_exists($img_path)) {
                if (!unlink($img_path)) {
                    echo json_encode(['status' => 'error', 'message' => "Failed to delete image: $img"]); // ถ้าลบไฟล์ไม่สำเร็จ
                    exit;
                }
            }
        } else {
            $new_img_paths[] = $img; // เก็บชื่อรูปภาพที่เหลืออยู่
        }
    }
}
$stmt_select->close(); // ปิด statement

// ตรวจสอบค่าของ new_img_paths ก่อนอัพเดท
$new_img_paths_str = implode(',', $new_img_paths);
error_log("New image paths: $new_img_paths_str"); // เพิ่มการบันทึกข้อผิดพลาดเพื่อการตรวจสอบ

// อัพเดทคอลัมน์ img ด้วยชื่อรูปภาพที่เหลืออยู่
$sql_update = "UPDATE notice SET img = ? WHERE id = ?";
$stmt_update = $conn->prepare($sql_update);
$stmt_update->bind_param("si", $new_img_paths_str, $id);

if ($stmt_update->execute()) {
    echo json_encode(['status' => 'success', 'message' => 'Images removed successfully', 'new_image_paths' => $new_img_paths_str]); // ส่งผลลัพธ์สำเร็จเป็น JSON
} else {
    echo json_encode(['status' => 'error', 'message' => 'Failed to update event images.']); // ส่งผลลัพธ์ข้อผิดพลาดเป็น JSON
}
$stmt_update->close(); // ปิด statement
$conn->close(); // ปิดการเชื่อมต่อฐานข้อมูล
