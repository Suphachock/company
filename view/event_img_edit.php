<?php
include_once "../conn.php";

// กำหนดจำนวนรูปภาพต่อหน้า
$images_per_page = 24;

// รับค่า page จาก POST หรือกำหนดค่าเริ่มต้นเป็น 1
$page = isset($_POST['page']) ? (int)$_POST['page'] : 1;
$start_from = ($page - 1) * $images_per_page;

// ดึงรูปภาพที่เกี่ยวข้องกับ event_id
$event_id = $_POST['id'];
$img_sql = "SELECT event_img FROM event WHERE id = ?";
$img_stmt = $conn->prepare($img_sql);
$img_stmt->bind_param("i", $event_id);
$img_stmt->execute();
$img_result = $img_stmt->get_result();
$img_stmt->close();

// ดึงข้อมูลรูปภาพทั้งหมด
$images = [];
if ($img_result) {
    while ($img = $img_result->fetch_assoc()) {
        $images = array_merge($images, explode(',', $img['event_img']));
    }
}

// คำนวณจำนวนหน้าทั้งหมด
$total_images = count($images);
$total_pages = ceil($total_images / $images_per_page);

// ดึงรูปภาพสำหรับหน้าปัจจุบัน
$current_page_images = array_slice($images, $start_from, $images_per_page);
?>

<div class="row align-items-center mb-3">
    <?php
    foreach ($current_page_images as $image) {
        if ($image) { ?>
            <div class="col-2 mb-3 position-relative">
                <!-- ปุ่มลบรูปภาพ -->
                <button type="button" class="close-btn" onclick="delImage(this, '<?= $event_id ?>')">X</button>
                <!-- รูปภาพ -->
                <img data-enlargable src="../img/event/<?= htmlspecialchars($image) ?>" style="width: 100%; height: 100px; object-fit: cover;" />
            </div>
    <?php }
    }
    ?>
</div>


<!-- Pagination -->
<nav aria-label="Page navigation example">
    <ul class="pagination justify-content-center">
        <?php for ($i = 1; $i <= $total_pages; $i++) { ?>
            <li class="page-item <?= $i == $page ? 'active' : '' ?>">
                <a class="page-link" href="#" onclick="loadPage(<?= $i ?>)"><?= $i ?></a>
            </li>
        <?php } ?>
    </ul>
</nav>

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
    });

    function loadPage(page) {
        let event_id = <?= $event_id ?>;
        $.ajax({
            type: "POST",
            url: "../view/event_img_edit.php",
            data: {
                id: event_id,
                page: page
            },
            dataType: "html",
            success: function(response) {
                $(".img_for_delete").html(response);
            }
        });
    }
</script>