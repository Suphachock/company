<?php
include_once "../conn.php";

$id = $_GET['id'];
// Prepare and execute the SQL query
$stmt = $conn->prepare("SELECT e.id, e.event_title, ec.event_category, e.event_img FROM event e JOIN event_category ec ON e.event_category = ec.id WHERE e.id = ?");
$stmt->bind_param("s", $id);
$stmt->execute();
$result = $stmt->get_result();
$row = $result->fetch_assoc();
?>
<div class="text-center fs-2 mb-3"><?= htmlspecialchars($row['event_title']) ?></div>
<div class="row mb-3">
    <?php if ($result && $result->num_rows > 0) {
        $images = explode(',', $row['event_img']); // แยกรูปภาพออกเป็นอาเรย์
        foreach ($images as $image) { ?>
            <div class="col-4 mb-3">
                <img data-enlargable src="img/event/<?= htmlspecialchars($image) ?>" style="width: 100%; height:300px; object-fit: cover;"/>
            </div>
        <?php }
    } else { ?>
        <div class="text-center fs-1">- ไม่มีข้อมูลในระบบ -</div>
    <?php } ?>
</div>

<?php
$stmt->close();
$conn->close();
?>
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
</script>