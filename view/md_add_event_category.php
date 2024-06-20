<div class="modal" tabindex="-1" id="md_event_category">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title">หมวดหมู่อีเว้นท์</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>

            <div class="modal-body">
                <div class="row mx-1 mt-1 align-items-center event_category_data">
                </div>
                <div class="row mx-1 mt-1 align-items-center">
                    <div class="col-auto px-0">
                        <label class="form-label">เพิ่มหมวดหมู่อีเว้นท์</label>
                    </div>
                    <div class="col-6">
                        <input type="text" class="form-control event_category" required>
                    </div>
                    <div class="col text-center p-0">
                        <button class="btn btn-success" onclick="add_event_category()"><i class="fa-solid fa-square-check"></i></button>
                    </div>
                </div>

            </div>
        </div>
    </div>
</div>

<script>
    $(document).ready(function() {
        show_table_event_category()
    });
</script>