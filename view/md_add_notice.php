<div class="modal" tabindex="-1" id="md_add_notice">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title">เพิ่มข่าวสาร</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <form id="add_notice_form" enctype="multipart/form-data">
                <div class="modal-body">
                    <div class="row align-items-center mb-3">
                        <div class="col-md-3">
                            <label for="notice_title" class="form-label">หัวข้อ</label>
                        </div>
                        <div class="col-md-9">
                            <input type="text" class="form-control" name="notice_title" required>
                        </div>
                    </div>
                    <div class="row align-items-center mb-3">
                        <div class="col-md-3">
                            <label for="notice_detail" class="form-label">รายละเอียด</label>
                        </div>
                        <div class="col-md-9">
                            <textarea class="form-control" name="notice_detail"></textarea>
                        </div>
                    </div>
                    <div class="row align-items-center mb-3">
                        <div class="col-md-3">
                            <label for="notice_detail" class="form-label">วันที่ประกาศ</label>
                        </div>
                        <div class="col-md-9">
                            <input type="text" id="datepicker" name="notice_date" class="form-control" required>
                        </div>
                    </div>
                    <div class="row align-items-center mb-3">
                        <div class="col-md-3">
                            <label for="notice_image" class="form-label">รูปภาพ</label>
                        </div>
                        <div class="col-md-9">
                            <input type="file" name="notice_image[]" class="form-control" accept="image/*" onchange="previewImage(event)" multiple>
                            <img id="image_preview" class="mt-3" src="" alt="Image preview" style="max-width: 100px; display: none;">
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
        $(function() {
            $("#datepicker").datepicker({
                dateFormat: 'yy-mm-dd'
            });
        });
        $('#add_notice_form').on('submit', function(event) {
            event.preventDefault();
            let formData = new FormData(this);
            $.ajax({
                url: '../model/add_notice.php', // The URL of your PHP script
                type: 'POST', // The HTTP method to use (POST)
                data: formData, // The form data
                processData: false, // Prevent jQuery from processing the data
                contentType: false, // Prevent jQuery from setting a default content type
                success: function(res) {
                    let response = JSON.parse(res)
                    if (response.status == "success") {
                        $("#md_add_notice").modal('hide');
                        manageNotice()
                    } else {
                        alert(response.message)
                    }
                }
            });
        });
    });
    function previewImage(event) {
        const fileInput = event.target;
        const file = fileInput.files[0];

        if (file) {
            const reader = new FileReader();
            const imagePreview = document.getElementById('image_preview');

            // This function runs when the FileReader has finished loading the file
            reader.onload = function(event) {
                // Update the src attribute of the image preview
                imagePreview.src = event.target.result;
                // Make the image preview visible
                imagePreview.style.display = 'block';
            };

            // Read the file as a Data URL (base64 encoded string)
            reader.readAsDataURL(file);
        } else {
            // If no file is selected, hide the image preview
            document.getElementById('image_preview').style.display = 'none';
            document.getElementById('image_preview').src = '';
        }
    }
</script>