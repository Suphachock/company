<?php
include_once "../conn.php";
$id = $_POST['id'];
$sql = "SELECT * FROM vdo WHERE id = $id";
$result = mysqli_query($conn, $sql);
$categories_sql = "SELECT * FROM vdo_category";
$categories_result = mysqli_query($conn, $categories_sql);

if ($result && $categories_result) {
    $row = mysqli_fetch_assoc($result);
    $categories = mysqli_fetch_all($categories_result, MYSQLI_ASSOC);
}
?>
<div class="modal" tabindex="-1" id="md_edit_vdo">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title">แก้ไขข้อมูลวิดิโอ</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <form id="edit_vdo" enctype="multipart/form-data">
                <input type="hidden" name="vdo_id" value="<?= $row['id'] ?>">
                <div class="modal-body">
                    <!-- Video title input -->
                    <div class="row align-items-center mb-3">
                        <div class="col-md-4">
                            <label for="vdo_title" class="form-label">หัวข้อวิดิโอ</label>
                        </div>
                        <div class="col-md-8">
                            <input type="text" name="vdo_title" class="form-control" value="<?= htmlspecialchars($row['vdo_title']) ?>" required>
                        </div>
                    </div>

                    <!-- Video category selection -->
                    <div class="row align-items-center mb-3">
                        <div class="col-md-4">
                            <label for="vdo_category" class="form-label">หมวดหมู่วิดิโอ</label>
                        </div>
                        <div class="col-md-8">
                            <select name="vdo_category" class="form-select" required>
                                <?php foreach ($categories as $category) : ?>
                                    <option value="<?= $category['id'] ?>" <?= $category['id'] == $row['vdo_category'] ? 'selected' : '' ?>>
                                        <?= htmlspecialchars($category['vdo_category']) ?>
                                    </option>
                                <?php endforeach; ?>
                            </select>
                        </div>
                    </div>
                    <!-- Video file input -->
                    <div class="row align-items-center mb-3">
                        <div class="col-md-4">
                            <label for="vdo_path" class="form-label">อัพไฟล์วิดิโอ (Mp4)</label>
                        </div>
                        <div class="col-md-8">
                            <input type="file" name="vdo_path[]" class="form-control" accept="video/mp4,video/x-m4v,video/*">
                        </div>
                    </div>
                    <!-- Video filename and card display section -->
                    <?php if (!empty($row['vdo_path'])) : ?>
                        <div class="mb-3">
                            <label for="vdo_current" class="form-label">ไฟล์วิดิโอปัจจุบัน:</label>
                            <?php
                            // Split the video paths using a comma as a delimiter
                            $videos = explode(',', $row['vdo_path']);
                            foreach ($videos as $video) : // Loop through each video
                            ?>
                                <div class="card mb-2">
                                    <div class="card-body d-flex justify-content-between align-items-center">
                                        <span><?= htmlspecialchars(basename(trim($video))) ?></span> <!-- Display the video name -->
                                        <button type="button" class="btn btn-danger btn-sm"> <i class="fa-solid fa-trash"></i> ลบไฟล์</button>
                                    </div>
                                </div>
                            <?php endforeach; ?>
                        </div>
                    <?php endif; ?>

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


<script>
    $(document).ready(function() {
        $('#edit_vdo').on('submit', function(event) {
            let formData = new FormData(this);
            event.preventDefault();
            $(".loading").show();
            $('button[type="submit"]').prop('disabled', true);
            $.ajax({
                url: '../model/edit_vdo.php', // The URL of your PHP script
                type: 'POST', // The HTTP method to use (POST)
                data: formData, // The form data
                processData: false, // Prevent jQuery from processing the data
                contentType: false, // Prevent jQuery from setting a default content type
                success: function(res) {
                    let response = JSON.parse(res);
                    $(".loading").hide();
                    $('button[type="submit"]').prop('disabled', false);
                    if (response.status === "success") {
                        $("#md_edit_vdo").modal('hide');
                        manageVdo();
                    } else {
                        alert(response.message);
                    }
                },
                error: function() {
                    $(".loading").hide();
                    $('button[type="submit"]').prop('disabled', false);
                    alert('An error occurred. Please try again.');
                }
            });
        });
    });
</script>