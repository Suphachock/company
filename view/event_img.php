<?php
include_once "../conn.php";

$limit = 20; // Number of images per page
$page = isset($_POST['page']) && is_numeric($_POST['page']) ? $_POST['page'] : 1;
$offset = ($page - 1) * $limit;

// ตรวจสอบว่า POST มี 'id' และเป็นตัวเลข
if(isset($_POST['id']) && is_numeric($_POST['id'])) {
    $id = $_POST['id'];
    $stmt = $conn->prepare("SELECT e.event_img FROM event e WHERE e.id = ?");
    $stmt->bind_param("i", $id);
    $stmt->execute();
    $result = $stmt->get_result();
    $row = $result->fetch_assoc();

    echo "<div class='row mb-3'>";

    if ($result && $result->num_rows > 0) {
        $images = explode(',', $row['event_img']);
        $total_images = count($images);
        $images = array_slice($images, $offset, $limit);

        foreach ($images as $image) {
            echo "<div class='col-lg-3 col-md-4 col-sm-6 mb-2'><img data-enlargable src='img/event/" . htmlspecialchars($image) . "' style='width: 100%; height:300px; object-fit: cover;'/></div>";
        }

        echo "</div>";

        // Pagination
        $total_pages = ceil($total_images / $limit);
        echo "<nav aria-label='Page navigation example'><ul class='pagination justify-content-center'>";
        for ($i = 1; $i <= $total_pages; $i++) {
            echo "<li class='page-item" . ($i == $page ? " active" : "") . "'><a class='page-link' href='#' data-page='$i'>$i</a></li>";
        }
        echo "</ul></nav>";
    } else {
        echo "<div class='text-center fs-1'>- ไม่มีข้อมูลในระบบ -</div>";
    }

    $stmt->close();
}

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

    // Pagination click event
    $('.pagination a').click(function(e) {
        e.preventDefault();
        var page = $(this).data('page');
        $.post('./event_img.php', {id: <?php echo $id; ?>, page: page}, function(data) {
            $('.img_detail').html(data);
        });
    });
});
</script>
