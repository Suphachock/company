<?php
include_once "../conn.php";
$sql = "SELECT * FROM event_category";
$result = mysqli_query($conn, $sql);
?>
<div class="modal" tabindex="-1" id="md_add_event">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title">เพิ่มข้อมูลอีเว้นท์</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <form id="add_event" enctype="multipart/form-data">
                <div class="modal-body">
                    <div class="row align-items-center mb-3">
                        <div class="col-md-4">
                            <label for="event_title" class="form-label">หัวข้ออีเว้นท์</label>
                        </div>
                        <div class="col-md-8">
                            <input type="text" name="event_title" class="form-control" required>
                        </div>
                    </div>
                    <div class="row align-items-center mb-3">
                        <div class="col-md-4">
                            <label class="form-label">หมวดหมู่อีเว้นท์</label>
                        </div>
                        <div class="col-md-8">
                            <select name="event_category" class="form-select">
                                <?php
                                if ($result) {
                                    foreach ($result as $row) { ?>
                                        <option value="<?= $row['id'] ?>"><?= $row['event_category'] ?></option>
                                <?php  }
                                } ?>
                            </select>
                        </div>
                    </div>
                    <div class="row align-items-center mb-3">
                        <div class="col-md-4">
                            <label for="event_img" class="form-label">ไฟล์ภาพ (JPG,PNG)</label>
                        </div>
                        <div class="col-md-8">
                            <input type="file" name="event_img[]" class="form-control" accept="image/*" required multiple>
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
        $('#add_event').on('submit', function(event) {
            event.preventDefault();
            let formData = new FormData(this);
            $(".loading").show();
            $('button[type="submit"]').prop('disabled', true);
            $.ajax({
                url: '../model/add_event.php', // The URL of your PHP script
                type: 'POST', // The HTTP method to use (POST)
                data: formData, // The form data
                processData: false, // Prevent jQuery from processing the data
                contentType: false, // Prevent jQuery from setting a default content type
                success: function(res) {
                    $(".loading").hide();
                    $('button[type="submit"]').prop('disabled', false);
                    let response = JSON.parse(res);
                    if (response.status === "success") {
                        $("#md_add_event").modal('hide');
                        manageEvent()
                    } else {
                        alert(response.message);
                    }
                }
            });
        });
    });
</script>