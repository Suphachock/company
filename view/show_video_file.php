<?php
include_once "../conn.php";
$id = $_POST['id'];
$stmt = $conn->prepare("SELECT vdo_path FROM vdo WHERE id = ?");
$stmt->bind_param("i", $id); // 'i' specifies the variable type is integer
$id = $_POST['id'];
$stmt->execute();
$result = $stmt->get_result();

if ($result) {
    $row = $result->fetch_assoc();
}
?>

<?php if (!empty($row) && !empty($row['vdo_path'])) : ?>
    <div class="mb-3">
        <label for="vdo_current" class="form-label">ไฟล์วิดิโอปัจจุบัน:</label>
        <?php
        // Split the video paths using a comma as a delimiter
        $videos = explode(',', $row['vdo_path']);
        foreach ($videos as $video) :
            $video = trim($video); // Trim whitespace
        ?>
            <div class="card mb-2">
                <div class="card-body d-flex justify-content-between align-items-center">
                    <span><?= htmlspecialchars(basename($video)) ?></span> <!-- Display the video name -->
                    <button type="button" class="btn btn-danger btn-sm" onclick="delete_video_file('<?= htmlspecialchars($video) ?>', <?= htmlspecialchars($id) ?>)">
                        <i class="fa-solid fa-trash"></i> ลบไฟล์
                    </button>
                </div>
            </div>
        <?php endforeach; ?>

    </div>
<?php endif; ?>