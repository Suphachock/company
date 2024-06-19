<?php
include('../conn.php'); // รวมไฟล์เชื่อมต่อฐานข้อมูล

$img_arr = $_POST['hiddenImages']; 
$current_img_path = '../img/event/';
$event_id = $_POST['id']; // รับ id ของ event จาก POST
$filenames = array_map(function($url) {
    return basename($url);
}, $img_arr);

// ดึงข้อมูลรูปภาพของ event ตาม id ที่ได้รับมา
$sql_select = "SELECT event_img FROM event WHERE id = ?";
$stmt_select = $conn->prepare($sql_select);
$stmt_select->bind_param("i", $event_id);
$stmt_select->execute();
$result = $stmt_select->get_result();

if (!$result) {
    die(json_encode(['status' => 'error', 'message' => 'Failed to retrieve event images.']));
}

// อาเรย์สำหรับเก็บชื่อรูปภาพที่เหลืออยู่
$new_img_paths = [];

if ($row = $result->fetch_assoc()) {
    $img_paths = explode(',', $row['event_img']); // แยกชื่อไฟล์รูปภาพออกตามจุลภาค
    foreach ($img_paths as $img) {
        if (in_array($img, $filenames)) { // ถ้ารูปภาพอยู่ในอาเรย์ $filenames
            $img_path = $current_img_path . $img;
            if (file_exists($img_path)) {
                if (unlink($img_path)) {
                    echo "Deleted $img_path\n"; // Debug
                } else {
                    echo "Failed to delete $img_path\n"; // Debug
                }
            } else {
                echo "$img_path does not exist\n"; // Debug
            }
        } else {
            $new_img_paths[] = $img; // เก็บชื่อรูปภาพที่เหลืออยู่
        }
    }
}
$stmt_select->close(); // ปิด statement

// อัพเดทคอลัมน์ event_img ด้วยชื่อรูปภาพที่เหลืออยู่
$new_img_paths_str = implode(',', $new_img_paths);
$sql_update = "UPDATE event SET event_img = ? WHERE id = ?";
$stmt_update = $conn->prepare($sql_update);
$stmt_update->bind_param("si", $new_img_paths_str, $event_id);

if ($stmt_update->execute()) {
    echo json_encode(['status' => 'success', 'message' => 'Images removed successfully', 'new_image_paths' => $new_img_paths_str]); // ส่งผลลัพธ์สำเร็จเป็น JSON
} else {
    echo json_encode(['status' => 'error', 'message' => 'Failed to update event images.']); // ส่งผลลัพธ์ข้อผิดพลาดเป็น JSON
}
$stmt_update->close(); // ปิด statement
$conn->close(); // ปิดการเชื่อมต่อฐานข้อมูล
?>
