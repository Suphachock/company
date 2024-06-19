<div class="modal" tabindex="-1" id="md_vdo_category">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title">หมวดหมู่วิดิโอ</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>

            <div class="modal-body">
                <div class="row mx-1 mt-1 vdo_category_data">
                </div>
                <div class="row mx-1 mt-1">
                    <div class="col-4">
                        <label class="form-label">เพิ่มหมวดหมู่วิดิโอ</label>
                    </div>
                    <div class="col-6">
                        <input type="text" class="vdo_category" class="form-control" required>
                    </div>
                    <div class="col-2 text-end">
                        <button class="btn btn-success" onclick="add_vdo_category()"><i class="fa-solid fa-square-check"></i></button>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<script>
    $(document).ready(function() {
        show_table_vdo_category()
    });
</script>