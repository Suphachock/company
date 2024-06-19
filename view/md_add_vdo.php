<?php
include_once "../conn.php";
$sql = "SELECT * FROM vdo_category";
$result = mysqli_query($conn, $sql);
?>
<div class="modal" tabindex="-1" id="md_add_vdo">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title">เพิ่มข้อมูลวิดิโอ</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <form id="add_vdo" enctype="multipart/form-data">
                <div class="modal-body">
                    <div class="row align-items-center mb-3">
                        <div class="col-md-4">
                            <label for="vdo" class="form-label">หัวข้อวิดิโอ</label>
                        </div>
                        <div class="col-md-8">
                            <input type="text" name="vdo_title" class="form-control" required>
                        </div>
                    </div>
                    <div class="row align-items-center mb-3">
                        <div class="col-md-4">
                            <label for="vdo" class="form-label">หมวดหมู่วิดิโอ</label>
                        </div>
                        <div class="col-md-8">
                            <select name="vdo_category" class="form-select">

                                <?php
                                if ($result) {
                                    foreach ($result as $row) { ?>
                                        <option><?= $row['vdo_category'] ?></option>
                                <?php  }
                                } ?>
                            </select>
                        </div>
                    </div>
                    <div class="row align-items-center mb-3">
                        <div class="col-md-4">
                            <label for="vdo" class="form-label">ไฟล์วิดิโอ (Mp4)</label>
                        </div>
                        <div class="col-md-8">
                            <input type="file" name="vdo_path" class="form-control" accept="video/mp4,video/x-m4v,video/*" required>
                        </div>
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="submit" class="btn btn-primary">
                        บันทึก
                        <div class="spinner-grow  spinner-grow-sm text-light loading" role="status" style="display: none;">
                        </div>
                    </button>
                </div>

            </form>
        </div>
    </div>
</div>

<script>
    $(document).ready(function() {
        $('#add_vdo').on('submit', function(event) {
            event.preventDefault();
            let formData = new FormData(this);
            $(".loading").show();
            $('button[type="submit"]').prop('disabled', true);
            $.ajax({
                url: '../model/add_vdo.php', // The URL of your PHP script
                type: 'POST', // The HTTP method to use (POST)
                data: formData, // The form data
                processData: false, // Prevent jQuery from processing the data
                contentType: false, // Prevent jQuery from setting a default content type
                success: function(res) {
                    if (res === "success") {
                        $(".loading").hide();
                        $('button[type="submit"]').prop('disabled', false);
                        $("#md_add_vdo").modal('hide');
                        manageVdo()
                    } else {
                        alert("Failed to add vdo!")
                    }
                }
            });
        });
    });
</script>