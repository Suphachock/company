<?php
include_once "../conn.php";
$id = $_POST['id'];
$sql = "SELECT * FROM vdo WHERE id = $id";
$result = mysqli_query($conn, $sql);
$categories_sql = "SELECT * FROM vdo_category"; // Assume you have a categories table
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
                <input type="hidden" name="vdo_id" value="<?= $row['id'] ?>"></input>
                <div class="modal-body">
                    <div class="row align-items-center mb-3">
                        <div class="col-md-4">
                            <label for="vdo_title" class="form-label">หัวข้อวิดิโอ</label>
                        </div>
                        <div class="col-md-8">
                            <input type="text" name="vdo_title" class="form-control" value="<?= htmlspecialchars($row['vdo_title']) ?>" required>
                        </div>
                    </div>
                    <div class="row align-items-center mb-3">
                        <div class="col-md-4">
                            <label for="vdo_category" class="form-label">หมวดหมู่วิดิโอ</label>
                        </div>
                        <div class="col-md-8">
                            <select name="vdo_category" class="form-select" required>
                                <?php foreach ($categories as $category) : ?>
                                    <option <?= $category['vdo_category'] == $row['vdo_category'] ? 'selected' : '' ?>>
                                        <?= htmlspecialchars($category['vdo_category']) ?>
                                    </option>
                                <?php endforeach; ?>
                            </select>
                        </div>
                    </div>
                    <div class="row align-items-center mb-3">
                        <div class="col-md-4">
                            <label for="vdo_path" class="form-label">ไฟล์วิดิโอ (Mp4)</label>
                        </div>
                        <div class="col-md-8">
                            <input type="file" name="vdo_path" class="form-control" accept="video/mp4,video/x-m4v,video/*">
                        </div>
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="submit" class="btn btn-primary">
                        บันทึก
                        <div class="spinner-grow spinner-grow-sm text-light loading" role="status" style="display: none;">
                        </div>
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