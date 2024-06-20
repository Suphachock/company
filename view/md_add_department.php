<div class="modal" tabindex="-1" id="md_department">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title">เพิ่มแผนก</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>

            <div class="modal-body">
                <div class="row mx-1 mt-1 align-items-center table_department">
                </div>
                <div class="row mx-1 mt-1 align-items-center">
                    <div class="col-auto px-0">
                        <label class="form-label">แผนก</label>
                    </div>
                    <div class="col-6">
                        <input type="text" class="form-control department" required>
                    </div>
                    <div class="col text-end px-2">
                        <button class="btn btn-success" onclick="add_department()"><i class="fa-solid fa-square-check"></i></button>
                    </div>
                </div>

            </div>
        </div>
    </div>
</div>
<div class="modal_edit_dept"></div>

<script>
    $(document).ready(function() {
        show_table_department()
    });
</script>