<?php
include_once "../conn.php";
$id = $_POST['id'];
$sql = "SELECT * FROM website WHERE id = $id";
$result = mysqli_query($conn, $sql);
if ($result) {
    foreach ($result as $row) {
    }
}
?>
<div class="modal" tabindex="-1" id="md_edit_website">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title">แก้ไขเว็บไซต์</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <form id="edit_website" enctype="multipart/form-data">
                <input type="hidden" name="id" value="<?= $row['id']?>">
                <div class="modal-body">
                    <div class="modal-body">
                        <div class="row align-items-center mb-3">
                            <div class="col-md-3">
                                <label for="web_name" class="form-label">ชื่อเว็บไซต์</label>
                            </div>
                            <div class="col-md-9">
                                <input type="text" class="form-control" name="web_name" value="<?= $row['web_name'] ?>" required>
                            </div>
                        </div>
                        <div class="row align-items-center mb-3">
                            <div class="col-md-3">
                                <label for="web_url" class="form-label">Url</label>
                            </div>
                            <div class="col-md-9">
                                <input type="text" class="form-control" name="web_url" value="<?= $row['web_url'] ?>" required>
                            </div>
                        </div>
                        <div class="row align-items-center mb-3">
                            <div class="col-md-3">
                                <label for="web_img" class="form-label">รูปเว็บไซต์</label>
                            </div>
                            <div class="col-md-9">
                                <input type="file" name="web_img" class="form-control" accept="image/*">
                                <!-- Image preview element -->
                            </div>
                        </div>
                        <div class="row">
                            <img src="../img/web_pic/<?= htmlspecialchars($row['web_img']) ?>" width="100px" alt="...">
                        </div>
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="submit" class="btn btn-success">บันทึก</button>
                </div>
            </form>
        </div>
    </div>
</div>

<script>
    $(document).ready(function() {
        $('#edit_website').on('submit', function(event) {
            event.preventDefault();
            let formData = new FormData(this);
            $.ajax({
                url: '../model/edit_wesite.php', // The URL of your PHP script
                type: 'POST', // The HTTP method to use (POST)
                data: formData, // The form data
                processData: false, // Prevent jQuery from processing the data
                contentType: false, // Prevent jQuery from setting a default content type
                success: function(res) {
                    if (res === "success") {
                        $("#md_edit_website").modal('hide');
                        manageWeb()
                    } else {
                        alert("Failed to edit website!")
                    }
                }
            });
        });
    });
</script>