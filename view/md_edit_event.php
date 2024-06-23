<?php
include_once "../conn.php";

// รับค่า id ของอีเว้นท์จาก POST
$event_id = $_POST['id'];

// เตรียมและรันคำสั่ง SQL เพื่อดึงข้อมูลอีเว้นท์
$stmt = $conn->prepare("SELECT e.id, e.event_title, e.event_category, e.event_img FROM event e WHERE e.id = ?");
$stmt->bind_param("i", $event_id);
$stmt->execute();
$result = $stmt->get_result();

// ดึงข้อมูลหมวดหมู่ทั้งหมด
$categories_sql = "SELECT * FROM event_category";
$categories_result = $conn->query($categories_sql);
$categories = $categories_result->fetch_all(MYSQLI_ASSOC);

// ประมวลผลผลลัพธ์ที่ดึงมาได้
if ($result && $result->num_rows > 0) {
    $row = $result->fetch_assoc();
} else {
    echo "No results found.";
    exit();
}

$stmt->close();
$conn->close();
?>

<div class="modal modal-lg" tabindex="-1" id="md_edit_event">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title">แก้ไขข้อมูลอีเว้นท์</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <form id="edit_event" enctype="multipart/form-data">
                <div class="modal-body">
                    <input type="hidden" name="event_id" value="<?= htmlspecialchars($row['id']) ?>">
                    <div class="row align-items-center mb-3">
                        <div class="col">
                            <label for="event_title" class="form-label">หัวข้ออีเว้นท์</label>
                            <input type="text" name="event_title" class="form-control" value="<?= htmlspecialchars($row['event_title']) ?>" required>
                        </div>
                        <div class="col">
                            <label for="event_category" class="form-label">หมวดหมู่อีเว้นท์</label>
                            <select name="event_category" class="form-select" required>
                                <?php foreach ($categories as $category) : ?>
                                    <option value="<?= htmlspecialchars($category['id']) ?>" <?= $category['id'] == $row['event_category'] ? 'selected' : '' ?>>
                                        <?= htmlspecialchars($category['event_category']) ?>
                                    </option>
                                <?php endforeach; ?>
                            </select>
                        </div>
                    </div>
                    <div class="img_for_delete"></div>
                    <div class="row align-items-center mb-3">
                        <div class="col-md-4">
                            <label for="event_img" class="form-label">รูปภาพ (JPG,PNG)</label>
                        </div>
                        <div class="col-md-8">
                            <input type="file" name="event_img[]" class="form-control" accept="image/*" multiple>
                        </div>
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="submit" class="btn btn-primary">
                        บันทึก
                        <div class="spinner-grow spinner-grow-sm text-light loading" role="status" style="display: none;"></div>
                    </button>
                </div>
            </form>
        </div>
    </div>
</div>

<!-- Modal -->
<div class="modal modal-lg" id="imageModal" tabindex="-1" aria-labelledby="imageModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered">
        <div class="modal-content">
            <div class="modal-body text-center">
                <img id="modalImage" src="" alt="Full Size Image" style="width: 100%; height: auto;">
            </div>
        </div>
    </div>
</div>

<script>
    $(document).ready(function() {
        img_for_delete(1);
    });

    function img_for_delete(page) {
        let event_id = <?= json_encode($event_id) ?>;
        $.ajax({
            type: "POST",
            url: "/TEST/view/event_img_edit.php",
            data: {
                id: event_id,
                page: page
            },
            dataType: "html",
            success: function(response) {
                $(".img_for_delete").html(response);
            }
        });
    }
</script>
