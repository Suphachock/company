<?php
include_once "../conn.php";
$id = $_POST['id'];
$sql = "SELECT * FROM notice WHERE id = $id";
$result = mysqli_query($conn, $sql);
$row = $result->fetch_assoc();
?>

<div class="modal" tabindex="-1" id="md_edit_notice">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title">แก้ไขข้อมูล</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <form id="edit_notice_form" enctype="multipart/form-data">
                <div class="modal-body">
                    <input type="hidden" name="id" value="<?= $id ?>">
                    <!-- Notice Title -->
                    <div class="row align-items-center mb-3">
                        <div class="col-md-3">
                            <label for="notice_title" class="form-label">หัวข้อ</label>
                        </div>
                        <div class="col-md-9">
                            <input type="text" class="form-control" name="notice_title" value="<?= htmlspecialchars($row['title']) ?>" required>
                        </div>
                    </div>
                    <!-- Notice Detail -->
                    <div class="row align-items-center mb-3">
                        <div class="col-md-3">
                            <label for="notice_detail" class="form-label">รายละเอียด</label>
                        </div>
                        <div class="col-md-9">
                            <textarea class="form-control" name="notice_detail" required><?= htmlspecialchars($row['detail']) ?></textarea>
                        </div>
                    </div>
                    <!-- Notice Date -->
                    <div class="row align-items-center mb-3">
                        <div class="col-md-3">
                            <label for="notice_date" class="form-label">วันที่ประกาศ</label>
                        </div>
                        <div class="col-md-9">
                            <input type="text" id="datepicker" name="notice_date" class="form-control" value="<?= htmlspecialchars($row['create_date']) ?>" required>
                        </div>
                    </div>
                    <!-- Notice Image -->
                    <div class="row align-items-center mb-3">
                        <div class="col-md-3">
                            <label for="notice_image" class="form-label">รูปภาพ</label>
                        </div>
                        <div class="col-md-9">
                            <input type="file" name="notice_image[]" class="form-control" accept="image/*" onchange="previewImage(event)" multiple>
                        </div>
                    </div>
                    <div class="row align-items-center mb-3">
                        <?php
                        $images = explode(',', $row['img']); // Assuming images are stored as comma-separated values
                        foreach ($images as $image) {
                            if (!empty($image)) {
                                // Use htmlspecialchars to prevent XSS attacks
                                $safeImage = htmlspecialchars($image);
                        ?>
                                <div class="col-4 mb-3 position-relative">
                                    <button type="button" class="close-btn" onclick="delImageNotice(this, '<?php echo $id; ?>')">X</button>
                                    <img src="../img/notice/<?php echo $safeImage; ?>" style="width: 100%; height: 100px; object-fit: cover;" />
                                </div>
                        <?php
                            }
                        }
                        ?>
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
        $("#datepicker").datepicker({
            dateFormat: 'yy-mm-dd'
        });

        $('#edit_notice_form').on('submit', function(event) {
            event.preventDefault();
            let formData = new FormData(this);
            $.ajax({
                url: '../model/edit_notice.php',
                type: 'POST',
                data: formData,
                processData: false,
                contentType: false,
                success: function(res) {
                    let response = JSON.parse(res);
                    if (response.status == "success") {
                        $("#md_edit_notice").modal('hide');
                        manageNotice();
                    } else {
                        alert(response.message);
                    }
                }
            });
        });
    });
    function delImageNotice(button, id) {
        const hiddenImagesNotice = []; // เก็บ URL ของรูปที่ถูกปิด
        alert("Are you sure?")
        const img = button.nextElementSibling;
        hiddenImagesNotice.push(img.src); // เก็บ URL รูป
        $(img).closest('.col-4').addClass('d-none'); // ใช้ d-none แทนการซ่อนรูปแบบธรรมดา
        console.log(hiddenImagesNotice); // แสดง URL รูปที่ถูกเก็บในคอนโซล
        $.ajax({
            url: '../model/del_notice_img.php',
            type: 'POST',
            data: {
                hiddenImagesNotice,
                id
            },
            success: function(res) {
                let response = JSON.parse(res);
                if (response.status === "success") {} else {
                    alert(response.message);
                }
            }
        });
    }
</script>