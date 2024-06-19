<?php
include_once "../conn.php";

// รับค่า id, event_title, event_category จาก POST
$event_id = $_POST['id'];

// เตรียมและรันคำสั่ง SQL เพื่อดึงข้อมูลอีเว้นท์
$stmt = $conn->prepare("SELECT e.id,e.event_title,e.event_category,e.event_img from event e WHERE e.id =?");
$stmt->bind_param("i", $event_id); // ใช้ bind_param เพื่อความปลอดภัย
$stmt->execute();
$result = $stmt->get_result();

// ดึงข้อมูลหมวดหมู่ทั้งหมด
$categories_sql = "SELECT * FROM event_category";
$categories_result = $conn->query($categories_sql);
$categories = $categories_result->fetch_all(MYSQLI_ASSOC);

// ดึงรูปภาพที่เกี่ยวข้องกับ event_title และ event_category
$img_sql = "SELECT event_img FROM event WHERE id =?";
$img_stmt = $conn->prepare($img_sql);
$img_stmt->bind_param("i", $event_id);
$img_stmt->execute();
$img_result = $img_stmt->get_result();

// ประมวลผลผลลัพธ์ที่ดึงมาได้
if ($result && $result->num_rows > 0) {
    $row = $result->fetch_assoc();
} else {
    echo "No results found.";
}

$stmt->close();
$img_stmt->close();
$conn->close();
?>

<div class="modal modal-lg" tabindex="-1" id="md_edit_event">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title">แก้ไขข้อมูลอีเว้นท์</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <form id="edit_event" enctype="multipart/form-data">
                <div class="modal-body">
                    <input type="hidden" name='event_id' value="<?= $row['id'] ?>">
                    <div class="row align-items-center mb-3">
                        <div class="col">
                            <label for="event_title" class="form-label">หัวข้ออีเว้นท์</label>
                            <input type="text" name="event_title" class="form-control" value="<?= htmlspecialchars($row['event_title']) ?>" required>
                        </div>
                        <div class="col">
                            <label for="event_category" class="form-label">หมวดหมู่อีเว้นท์</label>
                            <select name="event_category" class="form-select" required>
                                <?php foreach ($categories as $category) : ?>
                                    <option <?= $category['id'] == $row['event_category'] ? 'selected' : '' ?> value="<?= htmlspecialchars($category['id']) ?>">
                                        <?= htmlspecialchars($category['event_category']) ?>
                                    </option>
                                <?php endforeach; ?>
                            </select>
                        </div>
                    </div>
                    <div class="row align-items-center mb-3">
                        <?php
                        if ($img_result) {
                            while ($img = $img_result->fetch_assoc()) {
                                $images = explode(',', $img['event_img']);
                                foreach ($images as $image) { ?>
                                    <div class="col-2 mb-3 position-relative">
                                        <button type="button" class="close-btn" onclick="delImage(this,'<?= $event_id ?>')">X</button>
                                        <!-- <button type="button" class="btn btn-danger position-absolute top-0 end-0" aria-label="Close" onclick="deleteImage('<?= htmlspecialchars($image) ?>')">X</button> -->
                                        <img data-enlargable src="../img/event/<?= htmlspecialchars($image) ?>" style="width: 100%; height:100px; object-fit: cover;" />
                                    </div>
                        <?php }
                            }
                        }
                        ?>
                    </div>
                    <div class="row align-items-center mb-3">
                        <div class="col-md-4">
                            <label for="event_img" class="form-label">รูปภาพ (JPG,PNG)</label>
                        </div>
                        <div class="col-md-8">
                            <input type="file" name="event_img[]" class="form-control" accept="image/*" multiple>
                        </div>
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="submit" class="btn btn-primary">
                        บันทึก
                        <div class="spinner-grow spinner-grow-sm text-light loading" role="status" style="display: none;"></div>
                    </button>
                </div>
            </form>
        </div>
    </div>
</div>
<!-- Modal -->
<div class="modal modal-lg" id="imageModal" tabindex="-1" aria-labelledby="imageModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered">
        <div class="modal-content">
            <div class="modal-body text-center">
                <img id="modalImage" src="" alt="Full Size Image" style="width: 100%; height: auto;">
            </div>
        </div>
    </div>
</div>

<script>
    $(document).ready(function() {
        $('img[data-enlargable]').addClass('img-enlargable').click(function() {
            var src = $(this).attr('src');
            $('<div>').css({
                background: 'RGBA(0,0,0,.5) url(' + src + ') no-repeat center',
                backgroundSize: 'contain',
                width: '100%',
                height: '100%',
                position: 'fixed',
                zIndex: '10000',
                top: '0',
                left: '0',
                cursor: 'zoom-out'
            }).click(function() {
                $(this).remove();
            }).appendTo('body');
        });
        $('#edit_event').on('submit', function(event) {
            event.preventDefault();
            let formData = new FormData(this);
            $(".loading").show();
            $('button[type="submit"]').prop('disabled', true);
            $.ajax({
                url: '../model/edit_event.php',
                type: 'POST',
                data: formData,
                processData: false,
                contentType: false,
                success: function(res) {
                    let response = JSON.parse(res);
                    $(".loading").hide();
                    $('button[type="submit"]').prop('disabled', false);
                    if (response.status === "success") {
                        $("#md_edit_event").modal('hide');
                        manageEvent();
                    } else {
                        alert(response.message);
                    }
                },
                error: function() {
                    $(".loading").hide();
                    $('button[type="submit"]').prop('disabled', false);
                    alert('An error occurred. Please try again.');
                }
            });
        });
    });
    const hiddenImages = []; // เก็บ URL ของรูปที่ถูกปิด
    function delImage(button, id) {
        alert("Are you sure?")
        const img = button.nextElementSibling;
        hiddenImages.push(img.src); // เก็บ URL รูป
        $(img).closest('.col-2').addClass('d-none'); // ใช้ d-none แทนการซ่อนรูปแบบธรรมดา
        console.log(hiddenImages); // แสดง URL รูปที่ถูกเก็บในคอนโซล
        $.ajax({
            url: '../model/del_event_img.php',
            type: 'POST',
            data: {
                hiddenImages,
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