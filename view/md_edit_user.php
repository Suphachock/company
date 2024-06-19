<?php
include_once "../conn.php";
$id = $_POST['id'];
$sql = "SELECT * FROM user WHERE id = $id";
$result = mysqli_query($conn, $sql);
$row = mysqli_fetch_assoc($result); // ดึงข้อมูลผู้ใช้จากฐานข้อมูล

$department = "SELECT * FROM department";
$dept_result = $conn->query($department);
$dept_all = $dept_result->fetch_all(MYSQLI_ASSOC);
$user_permissions = explode(',', $row['permission']); // แยกสตริงสิทธิ์โดยใช้คอมม่า
?>
<div class="modal" tabindex="-1" id="md_edit_user">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title">แก้ไขสมาชิก</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <form id="edit_user" enctype="multipart/form-data">
                <input type="hidden" name="id" value="<?= $row['id'] ?>">
                <div class="modal-body">
                    <div class="row align-items-center mb-3">
                        <div class="col-md-3">
                            <label for="fullname" class="form-label">ชื่อ-นามสกุล</label>
                        </div>
                        <div class="col-md-9">
                            <input type="text" class="form-control" name="fullname" value="<?= $row['fullname'] ?>" required>
                        </div>
                    </div>
                    <div class="row align-items-center mb-3">
                        <div class="col-md-3">
                            <label for="username" class="form-label">ชื่อผู้ใช้</label>
                        </div>
                        <div class="col-md-9">
                            <input type="text" class="form-control" name="username" value="<?= $row['username'] ?>" required>
                        </div>
                    </div>
                    <div class="row align-items-center mb-3">
                        <div class="col-md-3">
                            <label for="password" class="form-label">รหัสผ่าน</label>
                        </div>
                        <div class="col-md-9">
                            <input type="password" class="form-control" name="password" value="<?= $row['password'] ?>" required>
                        </div>
                    </div>
                    <div class="row align-items-center mb-3">
                        <div class="col-md-3">
                            <label for="department" class="form-label">แผนก</label>
                        </div>
                        <div class="col-md-9">
                            <select name="department" class="form-select">
                                <?php foreach ($dept_all as $dept) : ?>
                                    <option <?= $dept['id'] == $row['department'] ? 'selected' : '' ?> value="<?= htmlspecialchars($dept['id']) ?>">
                                        <?= htmlspecialchars($dept['department']) ?>
                                    </option>
                                <?php endforeach; ?>
                            </select>
                        </div>
                    </div>
                    <div class="row align-items-center mb-3">
                        <div class="col-md-3">
                            <label for="permission" class="form-label">สิทธิ์การใช้งาน</label>
                        </div>
                        <div class="col-md-9">
                            <?php
                            // แปลงค่าต่างๆของสิทธิ์ให้อยู่ในรูปอาร์เรย์
                            $permissions = [
                                'website' => 'รวมเว็บไซต์บริษัท',
                                'video' => 'วิดิโอแนะนำ',
                                'event' => 'กิจกรรมของบริษัท',
                                'telephone' => 'เบอร์โทรภายในบริษัท',
                                'holiday' => 'วันหยุด',
                                'member' => 'ระบบสมาชิก'
                            ];

                            foreach ($permissions as $key => $label) {
                                $checked = in_array($key, $user_permissions) ? 'checked' : ''; // ตรวจสอบว่าควรจะมีการเลือกหรือไม่
                                echo '<div class="form-check">
                        <input class="form-check-input" type="checkbox" name="permission[]" value="' . $key . '" ' . $checked . '>
                        <label class="form-check-label" for="' . $key . '">' . $label . '</label>
                      </div>';
                            }
                            ?>
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
        $('#edit_user').on('submit', function(event) {
            event.preventDefault();
            let formData = new FormData(this);
            $.ajax({
                url: '../model/edit_user.php', // The URL of your PHP script
                type: 'POST', // The HTTP method to use (POST)
                data: formData, // The form data
                processData: false, // Prevent jQuery from processing the data
                contentType: false, // Prevent jQuery from setting a default content type
                success: function(res) {
                    let response = JSON.parse(res);
                    if (response.status == "success") {
                        $("#md_edit_user").modal('hide');
                        manageUser()
                    } else {
                        alert(response.message)
                    }
                }
            });
        });
    });
</script>