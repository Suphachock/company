<?php
include('../conn.php'); // รวมไฟล์เชื่อมต่อฐานข้อมูล

$event_id = $_POST['id']; // รับค่า event_id จากการส่งข้อมูลแบบ POST
$current_img_path = '../img/event/'; // กำหนด path ที่เก็บรูปภาพ

// ดึงข้อมูลรูปภาพของ event ตาม id ที่ได้รับมา
$sql_select = "SELECT event_img FROM event WHERE id = ?";
$stmt_select = $conn->prepare($sql_select);
$stmt_select->bind_param("i", $event_id);
$stmt_select->execute();
$result = $stmt_select->get_result();

// ลบไฟล์รูปภาพหากมีอยู่
if ($row = $result->fetch_assoc()) {
    $img_paths = explode(',', $row['event_img']); // แยกชื่อไฟล์รูปภาพออกตามจุลภาค
    foreach ($img_paths as $img) {
        $img_path = $current_img_path . $img;
        if (file_exists($img_path)) {
            unlink($img_path);
        }
    }
}
$stmt_select->close(); // ปิด statement

// ลบข้อมูล event ตาม id ที่ได้รับมา
$sql_delete = "DELETE FROM event WHERE id = ?";
$stmt_delete = $conn->prepare($sql_delete);
$stmt_delete->bind_param("i", $event_id);
if ($stmt_delete->execute()) {
    echo json_encode(['status' => 'success', 'success' => 'success']); // ส่งผลลัพธ์สำเร็จเป็น JSON
} else {
    echo json_encode(['status' => 'error', 'message' => 'Failed to delete event.']); // ส่งผลลัพธ์ข้อผิดพลาดเป็น JSON
}
$stmt_delete->close(); // ปิด statement
$conn->close(); // ปิดการเชื่อมต่อฐานข้อมูล
