<?php
include_once "../conn.php";
$sql = "SELECT * FROM holiday ORDER BY create_date DESC";
$result = mysqli_query($conn, $sql);
?>
<div class="row">
    <div class="col-lg-10 col-md-10 col-sm-9 col-9">
        <div class="text-center fs-2">จัดการวันหยุดบริษัท</div>
    </div>
    <div class="col-lg-2 col-md-2 col-sm-3 col-3">
        <button class="btn btn-primary" onclick="show_md_holiday_add()">
            <i class="fa-regular fa-image"></i> เพิ่มรูปภาพ
        </button>
    </div>
</div>
<div class="row mx-3 mt-3">
    <table class="table">
        <thead>
            <tr>
                <th scope="col">ลำดับ</th>
                <th scope="col">รูปภาพ</th>
                <th scope="col">วันที่สร้าง</th>
                <th scope="col" class="text-center">ลบ</th>
                <th scope="col" class="text-center">สถานะ</th>
            </tr>
        </thead>
        <tbody>
            <?php
            if ($result) {
                $counter = 1; // Initialize a counter for the row numbers
                while ($row = mysqli_fetch_assoc($result)) { ?>
                    <tr>
                        <td><?= htmlspecialchars($counter) ?></td>
                        <td>
                            <img data-enlargable src="../img/holiday/<?= htmlspecialchars($row['holiday_img']) ?>" class="img-fluid" style="max-width:100px; height:auto;" alt="...">
                        </td>
                        <td><?= htmlspecialchars($row['create_date']) ?></td>
                        <td class="text-center">
                            <button class="btn btn-danger " onclick="if(confirm('Do you want to delete Holiday!!')) { delete_holiday('<?= $row['id'] ?>','<?= $row['holiday_img'] ?>'); } return false;"><i class="fa-solid fa-trash"></i></button>
                        </td>
                        <td class="text-center">
                            <input type="checkbox" style="transform: scale(2);" <?php if ($row['status'] == 'active') echo 'checked';  ?> onchange="update_status('<?= $row['id'] ?>','<?= $row['status'] ?>')">
                        </td>
                    </tr>
                <?php
                    $counter++;
                }
            } else { ?>
                <div class="text-center fs-1">- ไม่มีข้อมูลในระบบ - </div>
            <?php } ?>
        </tbody>
    </table>
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
    });
</script>