<?php
include('../conn.php');

// Retrieve the video ID and paths to remove from POST data
$id = $_POST['id'];
$remove_paths = explode(',', $_POST['vdo_path']); // Paths to remove, split into an array

// Sanitize the ID
$id = filter_var($id, FILTER_SANITIZE_NUMBER_INT);

// SQL query to fetch the current video paths
$select_sql = "SELECT vdo_path FROM vdo WHERE id = ?";
if ($stmt = $conn->prepare($select_sql)) {
    $stmt->bind_param("i", $id);
    $stmt->execute();
    $stmt->bind_result($current_paths);
    $stmt->fetch();
    $stmt->close();
    
    // Convert current paths to an array
    $current_paths_array = explode(',', $current_paths);

    // Remove the specified paths
    $updated_paths_array = array_diff($current_paths_array, $remove_paths);
    $updated_paths = implode(',', $updated_paths_array);

    // SQL query to update the video path in the database
    $update_sql = "UPDATE vdo SET vdo_path = ? WHERE id = ?";
    if ($stmt = $conn->prepare($update_sql)) {
        $stmt->bind_param("si", $updated_paths, $id);
        $stmt->execute();
        $stmt->close();

        // Optionally, delete the removed video files
        foreach ($remove_paths as $path) {
            $path = trim($path);
            $full_path = '../vdo/' . $path;
            if (file_exists($full_path)) {
                unlink($full_path);
                echo json_encode(['status' => 'success', 'message' => 'ลบวิดิโอไฟล์สำเร็จ!']);
            } else {
                echo json_encode(['status' => 'error', 'message' => 'ไม่พบไฟล์วิดิโอ!']);
            }
        }
    } else {
        echo json_encode(['status' => 'error', 'message' => 'เกิดข้อผิดพลาด!']);
    }
} else {
    echo json_encode(['status' => 'error', 'message' => 'เกิดข้อผิดพลาด!']);
}

// Close the database connection
$conn->close();
?>
