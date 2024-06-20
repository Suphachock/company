<?php
include_once "../conn.php";
$department_id = $_POST['id'];
$sql = "SELECT department FROM department WHERE id = $department_id";
$result = mysqli_query($conn, $sql);
$row = $result->fetch_assoc();
?>
<div class="modal" tabindex="-1" id="md_edit_department">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title">แก้ไขแผนก</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <form id="edit_dept">
                <div class="modal-body">
                    <div class="row align-items-center mb-3">
                        <input type="hidden" name="id" value="<?= $department_id ?>">
                        <div class="col-9">
                            <input type="text" class="form-control" name="department" value="<?= $row['department'] ?>" required>
                        </div>
                        <div class="col-3">
                            <button type="submit" class="btn btn-success">บันทึก</button>
                        </div>
                    </div>
                </div>
            </form>
        </div>
    </div>
</div>

<script>
    $(document).ready(function() {
        $('#edit_dept').on('submit', function(event) {
            event.preventDefault();
            let formData = new FormData(this);
            $.ajax({
                url: '../model/edit_department.php', // The URL of your PHP script
                type: 'POST', // The HTTP method to use (POST)
                data: formData, // The form data
                processData: false, // Prevent jQuery from processing the data
                contentType: false, // Prevent jQuery from setting a default content type
                success: function(res) {
                    let response = JSON.parse(res);
                    if (response.status == "success") {
                        $("#md_edit_department").modal('hide');
                        show_table_department()
                    } else {
                        alert(response.message)
                    }
                }
            });
        });
    });
</script>