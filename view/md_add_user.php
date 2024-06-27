<?php
include_once "../conn.php";
$sql = "SELECT * FROM department";
$result = mysqli_query($conn, $sql);
?>
<div class="modal" tabindex="-1" id="md_add_user">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title">เพิ่มสมาชิก</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <form id="add_user">
                <div class="modal-body">
                    <div class="row align-items-center mb-3">
                        <div class="col-md-3">
                            <label for="fullname" class="form-label">ชื่อ-นามสกุล</label>
                        </div>
                        <div class="col-md-9">
                            <input type="text" class="form-control" name="fullname" required>
                        </div>
                    </div>
                    <div class="row align-items-center mb-3">
                        <div class="col-md-3">
                            <label for="username" class="form-label">ชื่อผู้ใช้</label>
                        </div>
                        <div class="col-md-9">
                            <input type="text" class="form-control" name="username" required>
                        </div>
                    </div>
                    <div class="row align-items-center mb-3">
                        <div class="col-md-3">
                            <label for="password" class="form-label">รหัสผ่าน</label>
                        </div>
                        <div class="col-md-9">
                            <input type="password" class="form-control" name="password" required>
                        </div>
                    </div>
                    <div class="row align-items-center mb-3">
                        <div class="col-md-3">
                            <label for="department" class="form-label">แผนก</label>
                        </div>
                        <div class="col-md-9">
                            <select name="department" class="form-select">
                                <?php
                                if ($result) {
                                    foreach ($result as $row) { ?>
                                        <option value="<?= $row['id'] ?>"><?= $row['department'] ?></option>
                                <?php  }
                                } ?>
                            </select>
                        </div>
                    </div>
                    <div class="row align-items-center mb-3">
                        <div class="col-md-3">
                            <label for="permission" class="form-label">สิทธิ์การใช้งาน</label>
                        </div>
                        <div class="col-md-9">
                            <div class="form-check">
                                <input class="form-check-input" type="checkbox" name="permission[]" value="website" style="transform: scale(1.5);" checked>
                                <label class="form-check-label" for="companyWebsite">
                                    รวมเว็บไซต์บริษัท
                                </label>
                            </div>
                            <div class="form-check">
                                <input class="form-check-input" type="checkbox" name="permission[]" value="video" style="transform: scale(1.5);" checked>
                                <label class="form-check-label" for="introVideo">
                                    วิดิโอแนะนำ
                                </label>
                            </div>
                            <div class="form-check">
                                <input class="form-check-input" type="checkbox" name="permission[]" value="event" style="transform: scale(1.5);" checked>
                                <label class="form-check-label" for="companyActivities">
                                    กิจกรรมของบริษัท
                                </label>
                            </div>
                            <div class="form-check">
                                <input class="form-check-input" type="checkbox" name="permission[]" value="telephone" style="transform: scale(1.5);" checked>
                                <label class="form-check-label" for="internalPhone">
                                    เบอร์โทรภายในบริษัท
                                </label>
                            </div>
                            <div class="form-check">
                                <input class="form-check-input" type="checkbox" name="permission[]" value="holiday" style="transform: scale(1.5);" checked>
                                <label class="form-check-label" for="holidays">
                                    วันหยุด
                                </label>
                            </div>
                            <div class="form-check">
                                <input class="form-check-input" type="checkbox" name="permission[]" value="member" style="transform: scale(1.5);" checked>
                                <label class="form-check-label" for="membershipSystem">
                                    ระบบสมาชิก
                                </label>
                            </div>
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
        $('#add_user').on('submit', function(event) {
            event.preventDefault();
            let formData = new FormData(this);
            formData.getAll("permission")
            for (var pair of formData.entries()) {
                console.log(pair[0] + ', ' + pair[1]);
            }
            $.ajax({
                url: '../model/add_user.php', // The URL of your PHP script
                type: 'POST', // The HTTP method to use (POST)
                data: formData, // The form data
                processData: false, // Prevent jQuery from processing the data
                contentType: false, // Prevent jQuery from setting a default content type
                success: function(res) {
                    if (res === "success") {
                        $("#md_add_user").modal('hide');
                        manageUser()
                    } else {
                        alert(res)
                    }
                }
            });
        });
    });
</script>