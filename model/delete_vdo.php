<?php
include('../conn.php');

$id = $_POST['id'];

// เตรียมคำสั่ง SQL เพื่อดึง vdo_path จากฐานข้อมูล
$sql = "SELECT vdo_path FROM vdo WHERE id = ?";
$stmt = $conn->prepare($sql);

// ผูกพารามิเตอร์
$stmt->bind_param("i", $id);

// ดำเนินการคำสั่ง
$stmt->execute();
$result = $stmt->get_result();

if ($row = $result->fetch_assoc()) {
    $vdo_path = $row['vdo_path'];

    // ลบระเบียนจากฐานข้อมูล
    $delete_sql = "DELETE FROM vdo WHERE id = ?";
    $delete_stmt = $conn->prepare($delete_sql);
    $delete_stmt->bind_param("i", $id);
    $delete_stmt->execute();
    $delete_stmt->close();

    // แยก vdo_path โดยใช้คอมม่าเป็นตัวแบ่ง
    if (!empty($vdo_path)) {
        $paths = explode(',', $vdo_path);
        foreach ($paths as $path) {
            $current_vdo_path = '../vdo/' . trim($path);
            if (file_exists($current_vdo_path)) {
                unlink($current_vdo_path); // ลบไฟล์
            }
        }
    }
    echo json_encode(['status' => 'success', 'message' => 'success']);
} else {
    echo json_encode(['status' => 'error', 'message' => 'เกิดข้อผิดพลาด!']);
}

// ปิดการเชื่อมต่อ
$stmt->close();
$conn->close();
?>
