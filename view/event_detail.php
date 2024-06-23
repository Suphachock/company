<?php
include_once "../conn.php"; // ใช้คำสั่งนี้เพื่อเชื่อมต่อกับฐานข้อมูล

// ตรวจสอบว่าได้รับ ID จากการร้องขอและมันเป็นตัวเลขหรือไม่
if (isset($_GET['id']) && is_numeric($_GET['id'])) {
    $id = $_GET['id'];
    $stmt = $conn->prepare("SELECT e.id, e.event_title FROM event e WHERE e.id = ?");
    $stmt->bind_param("i", $id); // ใช้ "i" เพื่อระบุว่าตัวแปรเป็น integer
    $stmt->execute();
    $result = $stmt->get_result();
    $row = $result->fetch_assoc();

    echo "<div class='text-center fs-2 mb-3'>" . htmlspecialchars($row['event_title']) . "</div>";
    echo "<div class='img_detail'></div>";

    $stmt->close();
}

$conn->close();
?>
<script>
    $(document).ready(function() {
        load_event_img(1); // Load the first page initially

        // Pagination click event
        $(document).on('click', '.pagination a', function(e) {
            e.preventDefault();
            var page = $(this).data('page');
            load_event_img(page);
        });
    });

    function load_event_img(page) {
        let id = <?= $id ?>;
        $.ajax({
            type: "POST",
            url: "/TEST/view/event_img.php",
            data: {
                id: id,
                page: page
            },
            dataType: "html",
            success: function(response) {
                $(".img_detail").html(response);
            }
        });
    }
</script>
